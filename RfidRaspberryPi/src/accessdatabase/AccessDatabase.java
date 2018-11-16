/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package accessdatabase;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Timestamp;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author hayato
 */
public class AccessDatabase {

    private Connection connect = null;
    //private Statement statement = null;

    public AccessDatabase() {
        try {
            connect = DriverManager.getConnection("jdbc:mysql://192.168.75.111:3306/reader-db?useSSL=true", "admin", "1234567890");
            //statement = connect.createStatement();
        } catch (Exception ex) {
            Logger.getLogger(AccessDatabase.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public void saveTag(String tag) {
        try {
            PreparedStatement preparedStatement = connect.prepareStatement("INSERT INTO tag_control VALUES (default,?,?,?,?)");
            preparedStatement.setString(1, tag);
            preparedStatement.setTimestamp(2, Timestamp.valueOf(LocalDateTime.now()));
            preparedStatement.setString(3, "");
            preparedStatement.setString(4, "");
            preparedStatement.executeUpdate();
        } catch (SQLException ex) {
            Logger.getLogger(AccessDatabase.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public ReaderSetting readSetting() {
        ReaderSetting readerSetting = new ReaderSetting();
        // init value
        readerSetting.setPower(16);
        readerSetting.setClearTime(5000);
        try {
            Statement statement = connect.createStatement();
            ResultSet resultSet = statement.executeQuery("SELECT * FROM reader_control");
            while (resultSet.next()) {
                String key = resultSet.getString("key");
                String value = resultSet.getString("value");
                switch (key) {
                    case "power":
                        readerSetting.setPower(Integer.parseInt(value));
                        break;
                    case "clear_time":
                        readerSetting.setClearTime(Integer.parseInt(value));
                        break;
                    default:
                        break;
                }
            }
            return readerSetting;
        } catch (Exception ex) {
            Logger.getLogger(AccessDatabase.class.getName()).log(Level.SEVERE, null, ex);
            return null;
        }
    }
}
