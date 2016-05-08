package com.sumarnakreatip.uiiot;

import android.app.ActionBar;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.Fragment;
import android.app.FragmentManager;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.v4.app.ActionBarDrawerToggle;
import android.support.v4.content.LocalBroadcastManager;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ListView;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GoogleApiAvailability;

import java.util.ArrayList;
import java.util.List;

public class Home extends Activity {

    private DrawerLayout mDrawerLayout;
    private ListView mDrawerList;
    private ActionBarDrawerToggle mDrawerToggle;

    private CharSequence mDrawerTitle;
    private CharSequence mTitle;
    CustomDrawerAdapter adapter;

    public String user,npm, id_tebengan, asal, tujuan, regid;
    boolean map = false;

    List<DrawerItem> dataList;

    private static final int PLAY_SERVICES_RESOLUTION_REQUEST = 9000;
    private static final String TAG = "Home_GCM_Regis";

    private BroadcastReceiver mRegistrationBroadcastReceiver;
    private boolean isReceiverRegistered;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        getWindow().requestFeature(Window.FEATURE_ACTION_BAR); // Add action bar again
        setContentView(R.layout.home);

        mRegistrationBroadcastReceiver = new BroadcastReceiver() {
            @Override
            public void onReceive(Context context, Intent intent) {
                SharedPreferences sharedPreferences =
                        PreferenceManager.getDefaultSharedPreferences(context);
                boolean sentToken = sharedPreferences
                        .getBoolean(SaveSharedPreference.SENT_TOKEN_TO_SERVER, false);
                if (sentToken) {
                    Log.i("Token","True");
                } else {
                    Log.i("Token","False");
                }
            }
        };

        // Registering BroadcastReceiver
        registerReceiver();

        if (checkPlayServices()) {
            // Start IntentService to register this application with GCM.
            Intent intent = new Intent(this, RegistrationIntentService.class);
            startService(intent);
        }

        user    = SaveSharedPreference.getUserName(Home.this);
        regid   = SaveSharedPreference.getUserID(Home.this);
        npm     = SaveSharedPreference.getNPM(Home.this);

        ActionBar actionBar = getActionBar();
        actionBar.show();
        actionBar.setCustomView(R.layout.actionbar_custom_view_home);
        actionBar.setDisplayShowCustomEnabled(true);

        dataList = new ArrayList<DrawerItem>();
        mTitle = mDrawerTitle = getTitle();
        mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
        mDrawerList = (ListView) findViewById(R.id.left_drawer);

        mDrawerLayout.setDrawerShadow(R.drawable.drawer_shadow,
                GravityCompat.START);

        // Add Drawer Item to dataList
        dataList.add(new DrawerItem("Home", R.drawable.ic_action_home));
        dataList.add(new DrawerItem("Profil", R.drawable.ic_action_profile));
        dataList.add(new DrawerItem("Beri Tebengan", R.drawable.ic_action_create));
        dataList.add(new DrawerItem("Tentang", R.drawable.ic_action_about));
        dataList.add(new DrawerItem("Log Out", R.drawable.ic_action_logout));

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

        SelectItem(0);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_option, menu);
        return true;
    }

    public void SelectItem(int possition) {

        Fragment fragment = null;
        Bundle args = new Bundle();
        switch (possition) {
            case 0:
                fragment = new Room();
                args.putString(Room.ITEM_NAME, dataList.get(possition)
                        .getItemName());
                args.putInt(Room.IMAGE_RESOURCE_ID, dataList.get(possition)
                        .getImgResID());
                break;
            case 1:
                fragment = new Profil();
                args.putString(Profil.ITEM_NAME, dataList.get(possition)
                        .getItemName());
                args.putInt(Profil.IMAGE_RESOURCE_ID, dataList.get(possition)
                        .getImgResID());
                break;
            case 2:
                fragment = new Room();
                Intent intent2 = new Intent(this, BeriTebengan.class);
                startActivity(intent2);
                map = false;
                break;
            case 3:
                fragment = new About();
                break;

            case 4:
                fragment = new LogOut();
                SaveSharedPreference.clearUserData(Home.this);
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
                    intent.putExtra("id_tebengan", id_tebengan);
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


    @Override
    protected void onResume() {
        super.onResume();
        registerReceiver();
        getApplicationContext().registerReceiver(mMessageReceiver, new IntentFilter("unique_name"));
    }

    @Override
    protected void onPause() {
        LocalBroadcastManager.getInstance(this).unregisterReceiver(mRegistrationBroadcastReceiver);
        isReceiverRegistered = false;
        getApplicationContext().unregisterReceiver(mMessageReceiver);
        super.onPause();
    }

    public void onDestroy() {
        super.onDestroy();
    }

    private void registerReceiver(){
        if(!isReceiverRegistered) {
            LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver,
                    new IntentFilter(SaveSharedPreference.REGISTRATION_COMPLETE));
            isReceiverRegistered = true;
        }
    }
    /**
     * Check the device to make sure it has the Google Play Services APK. If
     * it doesn't, display a dialog that allows users to download the APK from
     * the Google Play Store or enable it in the device's system settings.
     */
    private boolean checkPlayServices() {
        GoogleApiAvailability apiAvailability = GoogleApiAvailability.getInstance();
        int resultCode = apiAvailability.isGooglePlayServicesAvailable(this);
        if (resultCode != ConnectionResult.SUCCESS) {
            if (apiAvailability.isUserResolvableError(resultCode)) {
                apiAvailability.getErrorDialog(this, resultCode, PLAY_SERVICES_RESOLUTION_REQUEST)
                        .show();
            } else {
                Log.i(TAG, "This device is not supported.");
                finish();
            }
            return false;
        }
        return true;
    }

    //This is the handler that will manager to process the broadcast intent
    private BroadcastReceiver mMessageReceiver = new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {

            // Extract data included in the Intent
            final String message = intent.getStringExtra("message");

            //creating pop-up alert when application is active
            Log.i("ReceivePush", "Received a Push Notification: " + message.toString());
            runOnUiThread(new Runnable() {
                public void run() {
                    new AlertDialog.Builder(Home.this)
                            .setTitle("Nebengers Notification")
                            .setIcon(R.drawable.nebeng_icon_notif)
                            .setMessage(message)
                            .setPositiveButton(android.R.string.ok, new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int whichButton) {
                                }
                            })
                            .show();
                }
            });
        }
    };
}