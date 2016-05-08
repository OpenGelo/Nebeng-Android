/*
* Copyright 2015 The Android Open Source Project
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*     http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/

package com.sumarnakreatip.uiiot;


import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.widget.Toast;

import com.google.android.gms.common.GooglePlayServicesNotAvailableException;
import com.google.android.gms.common.GooglePlayServicesRepairableException;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.location.places.Place;
import com.google.android.gms.location.places.ui.PlacePicker;
import com.sumarnakreatip.uiiot.cardstream.Card;
import com.sumarnakreatip.uiiot.cardstream.CardStream;
import com.sumarnakreatip.uiiot.cardstream.CardStreamFragment;
import com.sumarnakreatip.uiiot.cardstream.OnCardClickListener;

/**
 * Sample demonstrating the use of {@link PlacePicker}.
 * This sample shows the construction of an {@link Intent} to open the PlacePicker from the
 * Google Places API for Android and select a {@link Place}.
 * <p/>
 * This sample uses the CardStream sample template to create the UI for this demo, which is not
 * required to use the PlacePicker API. (Please see the Readme-CardStream.txt file for details.)
 *
 * @see com.google.android.gms.location.places.ui.PlacePicker.IntentBuilder
 * @see com.google.android.gms.location.places.ui.PlacePicker
 * @see com.google.android.gms.location.places.Place
 */
public class PlacePickerFragment extends Fragment implements OnCardClickListener {

    private static final String TAG = "PlacePickerSample";

    private CardStreamFragment mCards = null;

    // Buffer used to display list of place types for a place
    private final StringBuffer mPlaceTypeDisplayBuffer = new StringBuffer();

    // Tags for cards
    private static final String CARD_INTRO = "INTRO";
    private static final String CARD_PICKER = "PICKER";
    private static final String CARD_DROPER = "DROPER";
    private static final String CARD_DETAIL = "DETAIL";
    private static final String CARD_DETAIL_DROP = "DETAIL_DROP_LOC";

    /**
     * Action to launch the PlacePicker from a card. Identifies the card action.
     */
    private static final int ACTION_PICK_PLACE = 1;
    private static final int ACTION_PICK_DROP = 2;

    /**
     * Request code passed to the PlacePicker intent to identify its result when it returns.
     */
    private static final int REQUEST_PLACE_PICKER = 1;
    private static final int REQUEST_PLACE_DROPPER = 2;

    Context layout;
    private String asal,tujuan;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        asal = "";
        tujuan ="";
    }

    @Override
    public void onResume() {
        super.onResume();

        // Check if cards are visible, at least the picker card is always shown.
        CardStreamFragment stream = getCardStream();
        if (stream.getVisibleCardCount() < 1) {
            // No cards are visible, sample is started for the first time.
            // Prepare all cards and show the intro card.
            initialiseCards();
            // Show the picker card and make it non-dismissible.
            getCardStream().showCard(CARD_PICKER, false);
            getCardStream().showCard(CARD_DROPER, false);
        }

    }

    @Override
    public void onCardClick(int cardActionId, String cardTag) {
        // BEGIN_INCLUDE(intent)
            /* Use the PlacePicker Builder to construct an Intent.
            Note: This sample demonstrates a basic use case.
            The PlacePicker Builder supports additional properties such as search bounds.
             */
        try {
            PlacePicker.IntentBuilder intentBuilder = new PlacePicker.IntentBuilder();
            Intent intent = intentBuilder.build(getActivity());
            // Start the Intent by requesting a result, identified by a request code.
            startActivityForResult(intent, cardActionId);

            // Hide the pick option in the UI to prevent users from starting the picker
            // multiple times.
            showPickAction(false);

        } catch (GooglePlayServicesRepairableException e) {
            GooglePlayServicesUtil
                    .getErrorDialog(e.getConnectionStatusCode(), getActivity(), 0);
        } catch (GooglePlayServicesNotAvailableException e) {
            Toast.makeText(getActivity(), "Google Play Services is not available.",
                    Toast.LENGTH_LONG)
                    .show();
        }

        // END_INCLUDE(intent)

    }

    /**
     * Extracts data from PlacePicker result.
     * This method is called when an Intent has been started by calling
     * {@link #startActivityForResult(Intent, int)}. The Intent for the
     * {@link com.google.android.gms.location.places.ui.PlacePicker} is started with
     * {@link #REQUEST_PLACE_PICKER} request code. When a result with this request code is received
     * in this method, its data is extracted by converting the Intent data to a {@link Place}
     * through the
     * {@link com.google.android.gms.location.places.ui.PlacePicker#getPlace(Intent,
     * android.content.Context)} call.
     *
     * @param requestCode
     * @param resultCode
     * @param data
     */
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        // BEGIN_INCLUDE(activity_result)

            // Enable the picker option
            showPickAction(true);

            if (resultCode == Activity.RESULT_OK) {
                /* User has picked a place, extract data.
                   Data is extracted from the returned intent by retrieving a Place object from
                   the PlacePicker.
                 */
                final Place place = PlacePicker.getPlace(data, getActivity());

                /* A Place object contains details about that place, such as its name, address
                and phone number. Extract the name, address, phone number, place ID and place types.
                 */
                final CharSequence name = place.getName();
                final CharSequence address = place.getAddress();
                final CharSequence phone = place.getPhoneNumber();
                final String placeId = place.getId();
                String attribution = PlacePicker.getAttributions(data);
                if (attribution == null) {
                    attribution = "";
                }

                if (requestCode == REQUEST_PLACE_PICKER) {
                    // Update data on card.
                    asal = name.toString();
                    getCardStream().getCard(CARD_PICKER)
                            .setTitle("Asal:" + name.toString())
                            .setDescription(getString(R.string.detail_text, address, attribution));
                }

                else if (requestCode == REQUEST_PLACE_DROPPER){
                    // Update data on card.
                    tujuan = name.toString();
                    getCardStream().getCard(CARD_DROPER)
                            .setTitle("Tujuan:" + name.toString())
                            .setDescription(getString(R.string.detail_text, address, attribution));
                }

                if(!asal.isEmpty() && !tujuan.isEmpty()){
                    Intent intent = new Intent(getActivity(), BeriTebengan.class);
                    intent.putExtra("asal",asal);
                    intent.putExtra("tujuan",tujuan);
                    intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    startActivity(intent);
                }
                // Print data to debug log
                Log.d(TAG, "Place selected: " + placeId + " (" + name.toString() + ")");

//                // Show the card.
//                getCardStream().showCard(CARD_DETAIL);

            } else {
                // User has not selected a place, hide the card.
                getCardStream().hideCard(CARD_DETAIL);
            }
        // END_INCLUDE(activity_result)
    }

    /**
     * Initializes the picker and detail cards and adds them to the card stream.
     */
    private void initialiseCards() {
        // Add picker card.
        Card c = new Card.Builder(this, CARD_PICKER)
                .setTitle(getString(R.string.pick_title))
                .setDescription(getString(R.string.pick_text))
                .addAction(getString(R.string.pick_action), ACTION_PICK_PLACE, Card.ACTION_NEUTRAL)
                .setLayout(R.layout.card_google)
                .build(getActivity());
        getCardStream().addCard(c, false);

        //try drop location card
        c = new Card.Builder(this, CARD_DROPER)
                .setTitle(getString(R.string.pick_drop_location))
                .setDescription(getString(R.string.pick_drop_text))
                .addAction(getString(R.string.pick_drop_action), ACTION_PICK_DROP, Card.ACTION_NEUTRAL)
                .setLayout(R.layout.card_google)
                .build(getActivity());
        getCardStream().addCard(c, false);

        // Add detail card.
        c = new Card.Builder(this, CARD_DETAIL)
                .setTitle(getString(R.string.empty))
                .setDescription(getString(R.string.empty))
                .build(getActivity());
        getCardStream().addCard(c, false);

//        c = new Card.Builder(this, CARD_DETAIL_DROP)
//                .setTitle(getString(R.string.empty))
//                .setDescription(getString(R.string.empty))
//                .build(getActivity());
//        getCardStream().addCard(c, false);
//
//        // Add and show introduction card.
//        c = new Card.Builder(this, CARD_INTRO)
//                .setTitle(getString(R.string.intro_title))
//                .setDescription("")
//                .build(getActivity());
//        getCardStream().addCard(c, false);
    }

    /**
     * Sets the visibility of the 'Pick Action' option on the 'Pick a place' card.
     * The action should be hidden when the PlacePicker Intent has been fired to prevent it from
     * being launched multiple times simultaneously.
     *
     * @param show
     */
    private void showPickAction(boolean show) {
        mCards.getCard(CARD_PICKER).setActionVisibility(ACTION_PICK_PLACE, show);
    }

    /**
     * Returns the CardStream.
     *
     * @return
     */
    private CardStreamFragment getCardStream() {
        if (mCards == null) {
            mCards = ((CardStream) getActivity()).getCardStream();
        }
        return mCards;
    }

}
