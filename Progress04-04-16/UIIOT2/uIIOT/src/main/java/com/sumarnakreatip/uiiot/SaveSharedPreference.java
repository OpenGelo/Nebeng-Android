package com.sumarnakreatip.uiiot;

import android.content.Context;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.preference.PreferenceManager;

public class SaveSharedPreference {

    static final String PREF_USER_NAME = "username";
    static final String PREF_NPM = "npm";
    static final String PREF_USER_ID = "user_id";

    static SharedPreferences getSharedPreferences(Context ctx) {
        return PreferenceManager.getDefaultSharedPreferences(ctx);
    }

    public static void setUserName(Context ctx, String userName) {
        Editor editor = getSharedPreferences(ctx).edit();
        editor.putString(PREF_USER_NAME, userName);
        editor.commit();
    }

    public static String getUserName(Context ctx) {
        return getSharedPreferences(ctx).getString(PREF_USER_NAME, "");
    }

    public static void clearUserData(Context ctx) {
        Editor editor = getSharedPreferences(ctx).edit();
        editor.clear(); //clear all stored data
        editor.commit();
    }

    public static void setNpm(Context ctx, String npm) {
        Editor editor = getSharedPreferences(ctx).edit();
        editor.putString(PREF_NPM, npm);
        editor.commit();
    }

    public static String getNPM(Context ctx) {
        return getSharedPreferences(ctx).getString(PREF_NPM, "");
    }

    public static void setUserID(Context ctx, String userId) {
        Editor editor = getSharedPreferences(ctx).edit();
        editor.putString(PREF_USER_ID, userId);
        editor.commit();
    }

    public static String getUserID(Context ctx) {
        return getSharedPreferences(ctx).getString(PREF_USER_ID, "");
    }
}
