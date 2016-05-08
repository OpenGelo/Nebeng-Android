package com.sumarnakreatip.uiiot;

import android.app.Activity;
import android.app.Dialog;
import android.app.Fragment;
import android.app.ProgressDialog;
import android.app.TimePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.content.res.Resources;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.text.Html;
import android.text.Spanned;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
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

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.GoogleApiClient.OnConnectionFailedListener;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.places.Place;
import com.google.android.gms.location.places.Places;

import com.google.android.gms.location.places.ui.PlaceAutocompleteFragment;
import com.google.android.gms.location.places.ui.PlaceSelectionListener;
import com.sumarnakreatip.android.common.activities.SampleActivityBase;
import com.sumarnakreatip.uiiot.cardstream.CardStream;
import com.sumarnakreatip.uiiot.cardstream.CardStreamFragment;
import com.sumarnakreatip.uiiot.cardstream.CardStreamState;
import com.sumarnakreatip.uiiot.cardstream.OnCardClickListener;
import com.sumarnakreatip.uiiot.cardstream.StreamRetentionFragment;

public final class BeriTebengan extends Activity implements PlaceSelectionListener {

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
    private GoogleApiClient mGoogleApiClient;

    public static final String TAG = "MainActivity";
    public static final String FRAGTAG = "PlacePickerFragment";

    private CardStreamFragment mCardStreamFragment;

    private StreamRetentionFragment mRetentionFragment;
    private static final String RETENTION_TAG = "retention";
    private FragmentActivity myContext;

    private TextView mPlaceDetailsText;

    private TextView mPlaceAttribution;

    //@Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.beritebengan_layout);

        // Retrieve the PlaceAutocompleteFragment.
        PlaceAutoComplete autocompleteFragment = (PlaceAutoComplete)
                getFragmentManager().findFragmentById(R.id.autocomplete_fragment);

        // Register a listener to receive callbacks when a place has been selected or an error has
        // occurred.
        autocompleteFragment.setOnPlaceSelectedListener(this);

        // Retrieve the TextViews that will display details about the selected place.
        mPlaceDetailsText = (TextView) findViewById(R.id.place_details);
        mPlaceAttribution = (TextView) findViewById(R.id.place_attribution);

        String asalMap = getIntent().getStringExtra("asal");
        String tujuanMap = getIntent().getStringExtra("tujuan");

        layout= getApplicationContext();
        username = SaveSharedPreference.getUserName(getApplicationContext());

        asal = (EditText) findViewById(R.id.asal);
        tujuan = (EditText) findViewById(R.id.tujuan);
        jl = (RadioGroup) findViewById(R.id.kuota);
        tv = (TextView) findViewById(R.id.w_b);
        btnChangeTime = (Button) findViewById(R.id.button2);
        keterangan = (EditText) findViewById(R.id.j_k);

        try{
            if(!asalMap.isEmpty() && !tujuanMap.isEmpty()) {
                asal.setText(asalMap);
                tujuan.setText(tujuanMap);
            }
        }
        catch (NullPointerException e){
            Log.e("String","not found");
        }

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
                Intent peta = new Intent(getApplicationContext(),Map.class);
                startActivity(peta);
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
                Toast.makeText(layout, "Sukses Dimasukkan", Toast.LENGTH_LONG).show();
                refresh();
            } else if (responseCheck.equalsIgnoreCase("Gagal")) {
                Toast.makeText(layout, "Gagal Dimasukkan", Toast.LENGTH_LONG).show();
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

    /**
     * Callback invoked when a place has been selected from the PlaceAutocompleteFragment.
     */
    @Override
    public void onPlaceSelected(Place place) {
        Log.i(TAG, "Place Selected: " + place.getName());

        // Format the returned place's details and display them in the TextView.
        mPlaceDetailsText.setText(formatPlaceDetails(getResources(), place.getName(), place.getId(),
                place.getAddress(), place.getPhoneNumber(), place.getWebsiteUri()));

        CharSequence attributions = place.getAttributions();
        if (!TextUtils.isEmpty(attributions)) {
            mPlaceAttribution.setText(Html.fromHtml(attributions.toString()));
        } else {
            mPlaceAttribution.setText("");
        }
    }

    /**
     * Callback invoked when PlaceAutocompleteFragment encounters an error.
     */
    @Override
    public void onError(Status status) {
        Log.e(TAG, "onError: Status = " + status.toString());

        Toast.makeText(this, "Place selection failed: " + status.getStatusMessage(),
                Toast.LENGTH_SHORT).show();
    }

    /**
     * Helper method to format information about a place nicely.
     */
    private static Spanned formatPlaceDetails(Resources res, CharSequence name, String id,
                                              CharSequence address, CharSequence phoneNumber, Uri websiteUri) {
        Log.e(TAG, res.getString(R.string.place_details, name, id, address, phoneNumber,
                websiteUri));
        return Html.fromHtml(res.getString(R.string.place_details, name, id, address, phoneNumber,
                websiteUri));

    }
}
