package com.sumarnakreatip.uiiot;

import android.os.Bundle;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;

import com.sumarnakreatip.android.common.activities.SampleActivityBase;
import com.sumarnakreatip.uiiot.cardstream.CardStream;
import com.sumarnakreatip.uiiot.cardstream.CardStreamFragment;
import com.sumarnakreatip.uiiot.cardstream.CardStreamState;
import com.sumarnakreatip.uiiot.cardstream.OnCardClickListener;
import com.sumarnakreatip.uiiot.cardstream.StreamRetentionFragment;

/**
 * Class Map Merupakan SampleActivityBase
 * Untuk render halaman menuju ke PlacePicker
 *
 * @author  Sanadhi Sutandi, Suryo
 * @version 0.3
 * @since   2016-03
 */

public class Map extends SampleActivityBase implements CardStream {
    public static final String TAG = "MainActivity";
    public static final String FRAGTAG = "PlacePickerFragment";

    private CardStreamFragment mCardStreamFragment;

    private StreamRetentionFragment mRetentionFragment;
    private static final String RETENTION_TAG = "retention";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.map_activity);

        FragmentManager fm = getSupportFragmentManager();
        PlacePickerFragment fragment =
                (PlacePickerFragment) fm.findFragmentByTag(FRAGTAG);

        if (fragment == null) {
            FragmentTransaction transaction = fm.beginTransaction();
            fragment = new PlacePickerFragment();
            transaction.add(fragment, FRAGTAG);
            transaction.commit();
        }

        // Use fragment as click listener for cards, but must implement correct interface
        if (!(fragment instanceof OnCardClickListener)){
            throw new ClassCastException("PlacePickerFragment must " +
                    "implement OnCardClickListener interface.");
        }
        OnCardClickListener clickListener = (OnCardClickListener) fm.findFragmentByTag(FRAGTAG);

        mRetentionFragment = (StreamRetentionFragment) fm.findFragmentByTag(RETENTION_TAG);
        if (mRetentionFragment == null) {
            mRetentionFragment = new StreamRetentionFragment();
            fm.beginTransaction().add(mRetentionFragment, RETENTION_TAG).commit();
        } else {
            // If the retention fragment already existed, we need to pull some state.
            // pull state out
            CardStreamState state = mRetentionFragment.getCardStream();

            // dump it in CardStreamFragment.
            mCardStreamFragment =
                    (CardStreamFragment) fm.findFragmentById(R.id.fragment_cardstream);
            mCardStreamFragment.restoreState(state, clickListener);
        }
    }

    public CardStreamFragment getCardStream() {
        if (mCardStreamFragment == null) {
            mCardStreamFragment = (CardStreamFragment)
                    getSupportFragmentManager().findFragmentById(R.id.fragment_cardstream);
        }
        return mCardStreamFragment;
    }

    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        CardStreamState state = getCardStream().dumpState();
        mRetentionFragment.storeCardStream(state);
    }
}
