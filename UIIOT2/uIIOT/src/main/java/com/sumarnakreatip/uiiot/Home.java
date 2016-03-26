package com.sumarnakreatip.uiiot;

import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import com.sumarnakreatip.uiiot.BeriTebengan.loggin;

import android.app.Activity;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.support.v4.app.ActionBarDrawerToggle;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.NotificationCompat;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

public class Home extends Activity {

    private DrawerLayout mDrawerLayout;
    private ListView mDrawerList;
    private ActionBarDrawerToggle mDrawerToggle;

    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;

    private CharSequence mDrawerTitle;
    private CharSequence mTitle;
    CustomDrawerAdapter adapter;

    public String user, asal, tujuan, kapasitas, w_b, k, regid;
    int maps = 0;
    private String kuota = "";
    boolean map = false, segarkan = false;

    private NotificationManager mNotificationManager;
    private int notificationID = 100;
    private int numMessages = 0;

    List<DrawerItem> dataList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.home);

        // Initializing
        user = getIntent().getExtras().getString("username");
        regid = getIntent().getExtras().getString("regid");
        kuota = getIntent().getExtras().getString("Kuota");
        maps = getIntent().getExtras().getInt("Map");
        segarkan = getIntent().getExtras().getBoolean("segar");

        //pemberitahuan asyncRate = new pemberitahuan();
        //asyncRate.execute();


        dataList = new ArrayList<DrawerItem>();
        mTitle = mDrawerTitle = getTitle();
        mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
        mDrawerList = (ListView) findViewById(R.id.left_drawer);

        mDrawerLayout.setDrawerShadow(R.drawable.drawer_shadow,
                GravityCompat.START);

        // Add Drawer Item to dataList
        dataList.add(new DrawerItem("Room", R.drawable.ic_action_cloud));
        dataList.add(new DrawerItem("Profil", R.drawable.ic_action_group));
        dataList.add(new DrawerItem("Beri Tebengan", R.drawable.ic_action_good));
        dataList.add(new DrawerItem("Tentang", R.drawable.ic_action_about));
        dataList.add(new DrawerItem("Log Out", R.drawable.ic_action_import_export));

        adapter = new CustomDrawerAdapter(this, R.layout.custom_drawer_item,
                dataList);

        mDrawerList.setAdapter(adapter);

        mDrawerList.setOnItemClickListener(new DrawerItemClickListener());

        getActionBar().setDisplayHomeAsUpEnabled(true);
        getActionBar().setHomeButtonEnabled(true);

        mDrawerToggle = new ActionBarDrawerToggle(this, mDrawerLayout,
                R.drawable.ic_drawer, R.string.drawer_open,
                R.string.drawer_close) {
            public void onDrawerClosed(View view) {
                getActionBar().setTitle(mTitle);
                invalidateOptionsMenu(); // creates call to
                // onPrepareOptionsMenu()
            }

            public void onDrawerOpened(View drawerView) {
                getActionBar().setTitle(mDrawerTitle);
                invalidateOptionsMenu(); // creates call to
                // onPrepareOptionsMenu()
            }
        };

        mDrawerLayout.setDrawerListener(mDrawerToggle);

        if (maps == 0) {
            SelectItem(0);
        } else if (maps == 1) {
            SelectItem(1);
        } else if (maps == 2) {
            if (!segarkan) {
                map = true;
                asal = getIntent().getExtras().getString("mulai");
                tujuan = getIntent().getExtras().getString("akhir");
                kapasitas = getIntent().getExtras().getString("kapasitas");
                w_b = getIntent().getExtras().getString("waktu_berangkat");
                k = getIntent().getExtras().getString("keterangan");
            } else {
                segarkan = false;
            }

            SelectItem(2);
        } else if (savedInstanceState == null) {
            SelectItem(0);
        }

    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.layout.menu_option, menu);
        return true;
    }

    public void SelectItem(int possition) {

        Fragment fragment = null;
        Bundle args = new Bundle();
        switch (possition) {
            case 0:
                fragment = new Room(Home.this, user, regid);
                args.putString(Room.ITEM_NAME, dataList.get(possition)
                        .getItemName());
                args.putInt(Room.IMAGE_RESOURCE_ID, dataList.get(possition)
                        .getImgResID());
                break;
            case 1:
                fragment = new Profil(Home.this, user, regid);
                args.putString(Profil.ITEM_NAME, dataList.get(possition)
                        .getItemName());
                args.putInt(Profil.IMAGE_RESOURCE_ID, dataList.get(possition)
                        .getImgResID());
                break;
            case 2:
                fragment = new BeriTebengan(Home.this, user, asal, tujuan, kapasitas, w_b, k, map, regid);
                args.putString(BeriTebengan.ITEM_NAME, dataList.get(possition)
                        .getItemName());
                args.putInt(BeriTebengan.IMAGE_RESOURCE_ID, dataList.get(possition)
                        .getImgResID());
                map = false;
                break;
            case 3:
                fragment = new About();
                break;

            case 4:
                fragment = new LogOut();
                SaveSharedPreference.clearUserName(Home.this);
                Intent intent = new Intent(this, LoginPage.class);
                intent.putExtra("regid", regid);
                startActivity(intent);
                finish();
                break;
            default:
                break;
        }

        fragment.setArguments(args);
        FragmentManager frgManager = getFragmentManager();
        frgManager.beginTransaction().replace(R.id.content_frame, fragment)
                .commit();

        mDrawerList.setItemChecked(possition, true);
        setTitle(dataList.get(possition).getItemName());
        mDrawerLayout.closeDrawer(mDrawerList);

    }

    @Override
    public void setTitle(CharSequence title) {
        mTitle = title;
        getActionBar().setTitle(mTitle);
    }

    @Override
    protected void onPostCreate(Bundle savedInstanceState) {
        super.onPostCreate(savedInstanceState);
        // Sync the toggle state after onRestoreInstanceState has occurred.
        mDrawerToggle.syncState();
    }

    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);
        // Pass any configuration change to the drawer toggles
        mDrawerToggle.onConfigurationChanged(newConfig);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // The action bar home/up action should open or close the drawer.
        // ActionBarDrawerToggle will take care of this.
        if (mDrawerToggle.onOptionsItemSelected(item)) {
            return true;
        }
        // Handle item selection
        switch (item.getItemId()) {
            case R.id.muatulang:
                //SelectItem(mDrawerList.getCheckedItemPosition());
                if (mDrawerList.getCheckedItemPosition() == 0) {
                    int value = 0;
                    Intent intent = new Intent(this, Home.class);
                    intent.putExtra("username", user);
                    intent.putExtra("Map", value);
                    intent.putExtra("regid", regid);
                    intent.putExtra("Kuota", kuota);
                    startActivity(intent);
                    finish();
                } else if (mDrawerList.getCheckedItemPosition() == 1) {
                    int value = 1;
                    Intent intent = new Intent(this, Home.class);
                    intent.putExtra("username", user);
                    intent.putExtra("Map", value);
                    intent.putExtra("regid", regid);
                    startActivity(intent);
                    finish();
                } else if (mDrawerList.getCheckedItemPosition() == 2) {
                    int value = 2;
                    Intent intent = new Intent(this, Home.class);
                    intent.putExtra("username", user);
                    intent.putExtra("regid", regid);
                    intent.putExtra("Map", value);
                    intent.putExtra("segar", true);
                    intent.putExtra("mulai", "");
                    intent.putExtra("akhir", "");
                    intent.putExtra("kapasitas", "");
                    intent.putExtra("waktu_berangkat", "");
                    intent.putExtra("keterangan", "");
                    startActivity(intent);
                    finish();
                } else {

                }
                return true;
            default:
                //return false;
                return super.onOptionsItemSelected(item);
        }
    }

    private class DrawerItemClickListener implements
            ListView.OnItemClickListener {
        @Override
        public void onItemClick(AdapterView<?> parent, View view, int position,
                                long id) {
            SelectItem(position);

        }
    }

    /**
     * public void onPause() {
     * <p/>
     * }
     * <p/>
     * <p/>
     * Call this on resume.
     * <p/>
     * public void onResume() {
     * <p/>
     * }
     */
    public void onDestroy() {
        super.onDestroy();
    }
        /*
        @Override
    	public void onBackPressed() {
    	}*/

    private class pemberitahuan extends AsyncTask<Void, String, String> {
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            //dialog = ProgressDialog.show(layout, "","Proccessing...", true);
        }

        protected String doInBackground(Void... params) {
            int a = 0;
            String finish = "";
            while (a <= 1080) {
                new CountDownTimer(10000, 1000) {

                    public void onTick(long millisUntilFinished) {

                    }

                    public void onFinish() {
                    }
                }.start();
                finish = ceknotif();
                if (finish.equalsIgnoreCase("kurang")) {
                    displayNotification(1);
                } else if (finish.equalsIgnoreCase("tambah")) {
                    displayNotification(2);
                } else {

                }
                a++;
            }
            return "selesai";
        }

        protected void onPostExecute(String rate) {

        }

    }

    String ceknotif() {
        try {

            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://green.ui.ac.id/nebeng/batal.php");
            //add your data
            nameValuePairs = new ArrayList<NameValuePair>(2);
            // Always use the same variable name for posting i.e the android side variable name and php side variable name should be <span id="IL_AD8" class="IL_AD">similar</span>,
            nameValuePairs.add(new BasicNameValuePair("username", user));  // $Edittext_value = $_POST['Edittext_value'];
            nameValuePairs.add(new BasicNameValuePair("kapasitas", kuota));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request
            // edited by James from coderzheaven.. <span id="IL_AD6" class="IL_AD">from here</span>....
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String response = httpclient.execute(httppost, responseHandler);
            System.out.println("Response : " + response);
            return response;
        } catch (Exception e) {
            String response = "Catch";
            System.out.println("Exception : " + e.getMessage());
            return response;
        }
    }

    @SuppressWarnings("deprecation")
    protected void displayNotification(int a) {
        Log.i("Start", "notification");
        String pesan;
              /* Creates an explicit intent for an Activity in your app */
        Intent resultIntent = new Intent(this, MainActivity.class);
        resultIntent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK
                | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        // Creates the PendingIntent
        PendingIntent resultPendingIntent =
                PendingIntent.getActivity(
                        this,
                        0,
                        resultIntent,
                        PendingIntent.FLAG_UPDATE_CURRENT
                );

        if (a == 1) {
            pesan = "Ada yang menebeng, silahkan cek profil anda.";
        } else if (a == 2) {
            pesan = "Ada yang batal menebeng, silahkan cek profil anda.";
        } else {
            pesan = "";
        }

        Notification notification = new Notification(R.drawable.ic_launcher, "PEMBERITAHUAN!", ++numMessages);
        NotificationCompat.Builder builder = new NotificationCompat.Builder(
                this);
        notification = builder.setContentIntent(resultPendingIntent)
                .setAutoCancel(true).setContentTitle("Pesan Baru")
                .setContentText(pesan).build();
        //notification.setLatestEventInfo(this, "Pesan Baru", pesan, resultPendingIntent);


        //notification.flags |= Notification.FLAG_AUTO_CANCEL;

        mNotificationManager =
                (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);

              /*notificationID allows you to update the notification later on.*/
        mNotificationManager.notify(notificationID, notification);
    }
}