package com.sumarnakreatip.uiiot;

import android.app.Activity;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.app.TimePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.places.Place;

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

public final class BeriTebengan extends Activity implements CustomPlaceSelectionListener, AdapterView.OnItemSelectedListener {

    Context layout;

    Button submit, gmaps;
    EditText keterangan;
    String type, username, kuota, waktu, w_b, ket;
    private String lokasiAsal, lokasiTujuan;
    StringBuilder wb;

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
    protected void onCreate(Bundle savedInstanceState) {
        getWindow().requestFeature(Window.FEATURE_ACTION_BAR); // Add action bar again
        super.onCreate(savedInstanceState);
        setContentView(R.layout.beritebengan_layout);

        // Retrieve the PlaceAutocompleteFragment.
        final PlaceAutoComplete autocompleteFragment = (PlaceAutoComplete)
                getFragmentManager().findFragmentById(R.id.autocomplete_fragment);
        final PlaceAutoComplete autocompleteFragmentDestionation = (PlaceAutoComplete)
                getFragmentManager().findFragmentById(R.id.autocomplete_fragment_tujuan);

        // Register a listener to receive callbacks when a place has been selected or an error has
        // occurred.
        autocompleteFragment.setOnPlaceSelectedListener(this, 1);
        autocompleteFragmentDestionation.setOnPlaceSelectedListener(this, 2);

        String asalMap = getIntent().getStringExtra("asal");
        String tujuanMap = getIntent().getStringExtra("tujuan");

        username = SaveSharedPreference.getUserName(getApplicationContext());

        tv = (TextView) findViewById(R.id.w_b);
        btnChangeTime = (Button) findViewById(R.id.button2);
        keterangan = (EditText) findViewById(R.id.j_k);

        //for spinner
        Spinner spinner = (Spinner) findViewById(R.id.capacity_spinner);
        // Create an ArrayAdapter using the string array and a default spinner layout
        ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(this,
                R.array.capacities_array, android.R.layout.simple_spinner_item);
        // Specify the layout to use when the list of choices appears
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        // Apply the adapter to the spinner
        spinner.setAdapter(adapter);
        spinner.setOnItemSelectedListener(this);

        try {
            if (!asalMap.isEmpty() && !tujuanMap.isEmpty()) {
                autocompleteFragment.setText(asalMap);
                autocompleteFragmentDestionation.setText(tujuanMap);
            }
        } catch (NullPointerException e) {
            Log.e("String", "not found");
        }

        submit = (Button) findViewById(R.id.button1);

        btnChangeTime.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onCreateDialog(TIME_DIALOG_ID).show();
            }
        });

        gmaps = (Button) findViewById(R.id.button4);

        gmaps.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent peta = new Intent(getApplicationContext(), Map.class);
                startActivity(peta);
            }
        });

        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                ket = keterangan.getText().toString().trim();
                lokasiAsal = autocompleteFragment.getText();
                lokasiTujuan = autocompleteFragmentDestionation.getText();

                try{
                    if (lokasiAsal.trim().equalsIgnoreCase("") &&
                            lokasiTujuan.trim().equalsIgnoreCase("") &&
                            type.equalsIgnoreCase("")) {
                        Toast.makeText(BeriTebengan.this, "Tolong Isi Form dengan Benar", Toast.LENGTH_LONG).show();
                    } else {
                        loggin asyncRate = new loggin();
                        asyncRate.execute();
                    }
                }
                catch (Exception e){
                    Toast.makeText(BeriTebengan.this, "Tolong Isi Form dengan Benar", Toast.LENGTH_LONG).show();
                }

            }
        });
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
            nameValuePairs.add(new BasicNameValuePair("asal", lokasiAsal.toString().trim()));  // $Edittext_value = $_POST['Edittext_value'];
            nameValuePairs.add(new BasicNameValuePair("tujuan", lokasiTujuan.toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("kapasitas", kuota));
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
        }

        @Override
        protected String doInBackground(Void... params) {
            String response = createTebengan();
            return response;
        }

        @Override
        protected void onPostExecute(String response) {
            String responseCheck = response;
            if (responseCheck.equalsIgnoreCase("Sukses")) {
                Toast.makeText(BeriTebengan.this, "Sukses Dimasukkan", Toast.LENGTH_LONG).show();
                refresh();
            } else if (responseCheck.equalsIgnoreCase("Gagal")) {
                Toast.makeText(BeriTebengan.this, "Gagal Dimasukkan", Toast.LENGTH_LONG).show();
            }
        }
    }

    void refresh() {
        Intent intent = new Intent(this, Home.class);
        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(intent);
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
                return new TimePickerDialog(BeriTebengan.this, timePickerListener, hour, minute, false);
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

    public void onItemSelected(AdapterView<?> parent, View view,
                               int pos, long id) {
        // An item was selected. You can retrieve the selected item using
        // parent.getItemAtPosition(pos)
        kuota = parent.getItemAtPosition(pos).toString();
    }

    public void onNothingSelected(AdapterView<?> parent) {
        // Another interface callback
    }


    /**
     * Callback invoked when a place has been selected from the PlaceAutocompleteFragment.
     */
    @Override
    public void onPlaceSelected(Place place, int opCode) {
        Log.i("PlaceAuto", "Place Selected: " + place.getName());
    }

    /**
     * Callback invoked when PlaceAutocompleteFragment encounters an error.
     */
    @Override
    public void onError(Status status) {
        Log.e("PlaceAutoErr", "onError: Status = " + status.toString());

        Toast.makeText(this, "Place selection failed: " + status.getStatusMessage(),
                Toast.LENGTH_SHORT).show();
    }
}
