package com.sumarnakreatip.uiiot;

/**
 * Interface CustomPlaceSelectionListener
 * Untuk custom place selection
 *
 * @author  Sanadhi Sutandi
 * @version 0.3
 * @since   2016-05
 */

import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.places.Place;

public interface CustomPlaceSelectionListener {
    void onPlaceSelected(Place var1, int code);

    void onError(Status var1);
}
