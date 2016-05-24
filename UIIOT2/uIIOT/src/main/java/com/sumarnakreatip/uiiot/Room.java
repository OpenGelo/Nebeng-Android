package com.sumarnakreatip.uiiot;

import android.annotation.SuppressLint;
import android.app.Fragment;
import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;

import com.sumarnakreatip.uiiot.RoomHttpClient.Function;
import com.sumarnakreatip.uiiot.RoomHttpClient.Product;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;

import java.util.ArrayList;
import java.util.List;

public class Room extends Fragment {

    public static final String IMAGE_RESOURCE_ID = "iconResourceID";
    public static final String ITEM_NAME = "itemName";
    String update;
    EditText e;
    Button b;

    //variabel bawaan
    Context layout;
    private String et, regid;

    //variabel class koneksi
    RoomHttpClient n;

    TextView note;

    //variabel koneksi
    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;

    //variabel tampilan list
    ArrayList<User> a = new ArrayList<User>();
    ListView userList;
    UserCustomAdapter userAdapter;

    @SuppressLint("InflateParams")
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        final View view = inflater.inflate(R.layout.nebeng, container, false);

        layout = getActivity();
        et    = SaveSharedPreference.getUserName(getActivity());
        regid   = SaveSharedPreference.getUserID(getActivity());

        final ListView lv = (ListView) view.findViewById(R.id.list_root);
        note = (TextView) view.findViewById(R.id.ket);

        //adapter untuk menampilkan data
        userAdapter = new UserCustomAdapter(layout, R.layout.room_tampil, a);

        n = new RoomHttpClient();
        //proses untuk mengambil data
        n.get_all_products(new Function<List<Product>, String, Void>() {

            @Override
            public Void call(List<Product> input, String sukses) {
                if (sukses.equalsIgnoreCase("2")) {
                    note.setText("Belum Ada Tebengan");
                } else {
                    for (Product p : input) {
                        userAdapter.addUser(
                                et,
                                (p.user_id).trim(),
                                (p.id_tebengan).trim(),
                                (p.npm).trim(),
                                (p.nama).trim(),
                                (p.username).trim(),
                                (p.asal).trim(),
                                (p.tujuan).trim(),
                                (p.kapasitas).trim(),
                                (p.waktu_berangkat).trim(),
                                (p.jam_berangkat).trim(),
                                (p.keterangan).trim(),
                                regid);
                        // TODO: useradapter.addUser()
                    }
                }
                return null;
            }
        });

        //untuk menampilkan data ke tampilan
        lv.setItemsCanFocus(false);
        lv.setAdapter(userAdapter);
        return view;
    }
}