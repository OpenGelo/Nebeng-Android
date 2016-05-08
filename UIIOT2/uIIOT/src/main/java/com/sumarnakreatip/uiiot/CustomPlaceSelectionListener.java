package com.sumarnakreatip.uiiot;

/**
 * Created by Sanadhi on 09/05/2016.
 */

import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.places.Place;

public interface CustomPlaceSelectionListener {
    void onPlaceSelected(Place var1, int code);

    void onError(Status var1);
}
