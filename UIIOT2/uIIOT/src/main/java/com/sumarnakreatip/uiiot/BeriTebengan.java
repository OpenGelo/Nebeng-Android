package com.sumarnakreatip.uiiot;

import android.app.Dialog;
import android.app.Fragment;
import android.app.ProgressDialog;
import android.app.TimePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public final class BeriTebengan extends Fragment {

    Context layout;

    Button submit, gmaps;
    EditText asal, tujuan, keterangan;
    RadioGroup jl;
    String type, ket, username, kuota, waktu, w_b, regid;
    StringBuilder wb;
    private boolean setbefore = false;

    private TextView tv;

    HttpPost httppost;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;

    //private TimePicker timePicker1;
    private Button btnChangeTime;

    private int hour;
    private int minute;

    static final int TIME_DIALOG_ID = 999;

    //@Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.beritebengan_layout, container,
                false);
        layout = getActivity();

        username = SaveSharedPreference.getUserName(getActivity());

        asal = (EditText) view.findViewById(R.id.asal);
        tujuan = (EditText) view.findViewById(R.id.tujuan);
        jl = (RadioGroup) view.findViewById(R.id.kuota);
        tv = (TextView) view.findViewById(R.id.w_b);
        btnChangeTime = (Button) view.findViewById(R.id.button2);
        keterangan = (EditText) view.findViewById(R.id.j_k);

        setCurrentTimeOnView(setbefore);
        if (setbefore) {
            setbefore = false;
            if (kuota.equalsIgnoreCase("1")) {
                jl.check(R.id.no_1);
            } else if (kuota.equalsIgnoreCase("2")) {
                jl.check(R.id.no_2);
            } else if (kuota.equalsIgnoreCase("3")) {
                jl.check(R.id.no_3);
            } else if (kuota.equalsIgnoreCase("4")) {
                jl.check(R.id.no_4);
            } else if (kuota.equalsIgnoreCase("5")) {
                jl.check(R.id.no_5);
            } else if (kuota.equalsIgnoreCase("6")) {
                jl.check(R.id.no_6);
            } else {

            }
        }

        submit = (Button) view.findViewById(R.id.button1);

        gmaps = (Button) view.findViewById(R.id.button4);


        btnChangeTime.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onCreateDialog(TIME_DIALOG_ID).show();

            }
        });
        gmaps.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                int checkedRadioButtonId = jl.getCheckedRadioButtonId();
                if (checkedRadioButtonId == R.id.no_1) {
                    type = "1";
                } else if (checkedRadioButtonId == R.id.no_2) {
                    type = "2";
                } else if (checkedRadioButtonId == R.id.no_3) {
                    type = "3";
                } else if (checkedRadioButtonId == R.id.no_4) {
                    type = "4";
                } else if (checkedRadioButtonId == R.id.no_5) {
                    type = "5";
                } else if (checkedRadioButtonId == R.id.no_6) {
                    type = "6";
                } else {
                    type = "";
                }
                if (keterangan.getText().toString().trim().equalsIgnoreCase("")) {
                    ket = " ";
                } else {
                    ket = keterangan.getText().toString().trim();
                }
            }
        });

        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                int checkedRadioButtonId = jl.getCheckedRadioButtonId();
                if (checkedRadioButtonId == R.id.no_1) {
                    type = "1";
                } else if (checkedRadioButtonId == R.id.no_2) {
                    type = "2";
                } else if (checkedRadioButtonId == R.id.no_3) {
                    type = "3";
                } else if (checkedRadioButtonId == R.id.no_4) {
                    type = "4";
                } else if (checkedRadioButtonId == R.id.no_5) {
                    type = "5";
                } else if (checkedRadioButtonId == R.id.no_6) {
                    type = "6";
                } else {
                    type = "";
                }
                if (keterangan.getText().toString().trim().equalsIgnoreCase("")) {
                    ket = " ";
                } else {
                    ket = keterangan.getText().toString().trim();
                }

                if (asal.getText().toString().trim().equalsIgnoreCase("") &&
                        tujuan.getText().toString().trim().equalsIgnoreCase("") &&
                        type.equalsIgnoreCase("")) {
                    Toast.makeText(layout, "Tolong Isi Form dengan Benar", Toast.LENGTH_LONG).show();
                } else {
                    loggin asyncRate = new loggin();
                    asyncRate.execute();
                }
            }
        });

        return view;
    }


    String createTebengan() {
        String response = "Gagal"; //default
        try {
            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://green.ui.ac.id/nebeng/back-system/create_tebengan.php");
            //add your data
            nameValuePairs = new ArrayList<NameValuePair>(2);
            // Always use the same variable name for posting i.e the android side variable name and php side variable name should be <span id="IL_AD8" class="IL_AD">similar</span>, 
            nameValuePairs.add(new BasicNameValuePair("username", username.toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("asal", asal.getText().toString().trim()));  // $Edittext_value = $_POST['Edittext_value'];
            nameValuePairs.add(new BasicNameValuePair("tujuan", tujuan.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("kapasitas", type.toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("waktu_berangkat", w_b.toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("keterangan", ket.toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            String httpResponse = httpclient.execute(httppost, responseHandler).trim();
            JSONObject jsonObject = new JSONObject(httpResponse);
            if (jsonObject.has("result")) {
                response = jsonObject.optString("result");
            }
            return response;
        } catch (Exception e) {
            response = "Gagal";
            return response;
        }
    }


    public class loggin extends AsyncTask<Void, String, String> {

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            dialog = ProgressDialog.show(layout, "", "Proccessing...", true);
        }

        @Override
        protected String doInBackground(Void... params) {
            String response = createTebengan();
            return response;
        }

        @Override
        protected void onPostExecute(String response) {
            String responseCheck = response;
            dialog.dismiss();
            if (responseCheck.equalsIgnoreCase("Sukses")) {
                Toast.makeText(layout, "Sukses Dimasukkan", Toast.LENGTH_LONG).show();
                refresh();
            } else if (responseCheck.equalsIgnoreCase("Gagal")) {
                Toast.makeText(layout, "Gagal Dimasukkan", Toast.LENGTH_LONG).show();
            }
        }
    }

    void refresh() {
        Intent intent = new Intent(getActivity(), Home.class);
        startActivity(intent);
        getActivity().finish();
    }

    // display current time
    public void setCurrentTimeOnView(boolean a) {
        if (a) {
            tv.setText(waktu);
            w_b = waktu;
        } else {
            final Calendar c = Calendar.getInstance();
            hour = c.get(Calendar.HOUR_OF_DAY);
            minute = c.get(Calendar.MINUTE);

            tv.setText(
                    new StringBuilder().append(pad(hour))
                            .append(":").append(pad(minute)));
            wb = new StringBuilder().append(pad(hour)).append(".").append(pad(minute));
            w_b = wb.toString();
        }
    }

    protected Dialog onCreateDialog(int id) {
        switch (id) {
            case TIME_DIALOG_ID:
                // set time picker as current time
                return new TimePickerDialog(layout, timePickerListener, hour, minute, false);
        }
        return null;
    }

    private TimePickerDialog.OnTimeSetListener timePickerListener =
            new TimePickerDialog.OnTimeSetListener() {
                public void onTimeSet(TimePicker view, int selectedHour,
                                      int selectedMinute) {
                    hour = selectedHour;
                    minute = selectedMinute;

                    // set current time into textview
                    tv.setText(new StringBuilder().append(pad(hour))
                            .append(":").append(pad(minute)));
                    wb = new StringBuilder().append(pad(hour)).append(".").append(pad(minute));
                    w_b = wb.toString();

                }
            };

    private static String pad(int c) {
        if (c >= 10)
            return String.valueOf(c);
        else
            return "0" + String.valueOf(c);
    }
}
