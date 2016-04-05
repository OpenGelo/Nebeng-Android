package com.sumarnakreatip.uiiot;

import android.app.Application;

/**
 * Created by Sanadhi on 04/04/2016.
 */
public class UserCredentials extends Application{

    private String user_id, npm, username, nama;
    private String asal;
    private String tujuan;

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }

    public String getNpm() {
        return npm;
    }

    public void setNpm(String npm) {
        this.npm = npm;
    }

    public String getnama() {
        return nama;
    }

    public void setNama(String namaPengguna) {
        this.nama = namaPengguna;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getasal() {
        return asal;
    }

    public String gettujuan() {
        return tujuan;
    }

}
