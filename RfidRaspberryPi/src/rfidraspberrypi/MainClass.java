/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package rfidraspberrypi;

import accessdatabase.AccessDatabase;
import accessdatabase.ReaderSetting;
import com.pi4j.io.i2c.I2CFactory;
import com.pi4j.io.serial.Baud;
import com.pi4j.io.serial.DataBits;
import com.pi4j.io.serial.FlowControl;
import com.pi4j.io.serial.Parity;
import com.pi4j.io.serial.Serial;
import com.pi4j.io.serial.SerialConfig;
import com.pi4j.io.serial.SerialDataEvent;
import com.pi4j.io.serial.SerialDataEventListener;
import com.pi4j.io.serial.SerialFactory;
import com.pi4j.io.serial.StopBits;
import grovepi4j.GrovePi4J;
import grovepi4j.Monitor;
import java.io.IOException;
import java.util.Hashtable;
import java.util.List;
import java.util.concurrent.locks.ReentrantLock;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.stream.Collectors;
import org.iot.raspberry.grovepi.GrovePi;
import org.iot.raspberry.grovepi.devices.GroveRgbLcd;

/**
 *
 * @author hayato
 */
public class MainClass {

    static byte[] setAntennaPortPower = new byte[]{0x01, 0x00, 0x06, 0x07, 0x00, 0x00, 0x00, 0x00};
    static byte[] setwInventoryExec = new byte[]{0x01, 0x00, 0x00, (byte) -16, 0x0f, 0x00, 0x00, 0x00};
    static byte[] recvCmdBegin = new byte[]{0x01, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00};
    static byte[] recvCmdEnd = new byte[]{0x01, 0x00, 0x01, 0x00, 0x00, 0x00, 0x00, 0x00};
    static byte[] recvInventoryResponse = new byte[]{0x01, 0x00, 0x05, 0x00, 0x00, 0x00, 0x00, 0x00};
    static Hashtable<String, Long> tagList = new Hashtable();
    static Serial serial = SerialFactory.createInstance();
    static SerialConfig config = new SerialConfig();
    static boolean canRead = false;
    static ReentrantLock lock = new ReentrantLock();
    static AccessDatabase accessDatabase = new AccessDatabase();
    static GrovePi grovePi;
    static Monitor monitor;
    static GroveRgbLcd lcd;
    static String lastTag = "";

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        try {

            grovePi = new GrovePi4J();
            monitor = new Monitor();
            lcd = grovePi.getLCD();

            serial.addListener(new SerialDataEventListener() {
                @Override
                public void dataReceived(SerialDataEvent event) {
                    try {
                        byte[] data = event.getBytes();
                        if (data.length < 16) {
                            return;
                        }
                        if (data.length == 16) {
                            if (data[0] == recvCmdBegin[0] && data[1] == recvCmdBegin[1] && data[2] == recvCmdBegin[2] && data[3] == recvCmdBegin[3]) {
                                canRead = true;
                                return;
                            }
                        }

                        if (!canRead) {
                            return;
                        }

                        if (data[0] == recvInventoryResponse[0] && data[2] == recvInventoryResponse[2] && data[3] == recvInventoryResponse[3]) {
                            int wantLen = 8 + data[4] * 4;
                            if (data.length > wantLen && wantLen > 20) {
                                int epcLen = (data[20] / 8) * 2;
                                String epc = "";
                                for (int i = 0; i < epcLen; i++) {
                                    epc += String.format("%02x", data[22 + i]);
                                }
                                if (epc.length() > 0) {
                                    if (lastTag.equals("")) {
                                        lastTag = epc;
                                        lcd.setText("EPC:" + lastTag);
                                    }
                                    if (!tagList.containsKey(epc)) {
                                        accessDatabase.saveTag(epc);
                                    }
                                    lock.lock();
                                    try {
                                        tagList.put(epc, System.currentTimeMillis());
                                    } finally {
                                        lock.unlock();
                                    }
                                }

                            }
                        }

                    } catch (IOException ex) {
                        Logger.getLogger(MainClass.class.getName()).log(Level.SEVERE, null, ex);
                    }
                }
            });
            config.device(Serial.FIRST_USB_COM_PORT).baud(Baud._115200).dataBits(DataBits._8).parity(Parity.NONE).stopBits(StopBits._1).flowControl(FlowControl.NONE);
            Thread t = new Thread(() -> {
                liveCheck();
            });
            t.start();
        } catch (IOException | I2CFactory.UnsupportedBusNumberException ex) {
            Logger.getLogger(MainClass.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public static void liveCheck() {
        while (true) {
            try {
                if (!serial.isOpen()) {
                    serial.open(config);
                }
                ReaderSetting readerSetting = accessDatabase.readSetting();
                int pow = readerSetting.getPower() * 10;
                setAntennaPortPower[4] = (byte) (pow & 0x00FF);
                setAntennaPortPower[5] = (byte) (pow / 256);
                serial.write(setAntennaPortPower);
                serial.write(setwInventoryExec);

                if (tagList.size() > 0) {
                    List<String> tagListRemove = tagList.keySet().stream().filter((key) -> (System.currentTimeMillis() - (long) tagList.get(key) > readerSetting.getClearTime())).collect(Collectors.toList());
                    lock.lock();
                    try {
                        tagListRemove.forEach((key) -> {
                            tagList.remove(key);
                        });
                        if (!tagList.containsKey(lastTag)) {
                            lastTag = "";
                            lcd.setText(lastTag);
                        }
                    } finally {
                        lock.unlock();
                    }
                }

                Thread.sleep(300);

            } catch (IOException | IllegalStateException | InterruptedException ex) {
                Logger.getLogger(MainClass.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
}
