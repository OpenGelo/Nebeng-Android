package com.sumarnakreatip.uiiot;

import android.content.Intent;

import com.google.android.gms.iid.InstanceIDListenerService;

/**
 * Class MyInstanceIDListenerService Merupakan Instance Listener Pesan GCM
 *
 * @author  Sanadhi Sutandi
 * @version 0.3
 * @since   2016-05
 */

public class MyInstanceIDListenerService extends InstanceIDListenerService {
    @Override
    public void onTokenRefresh() {
        // Fetch updated Instance ID token and notify our app's server of any changes (if applicable).
        Intent intent = new Intent(this, RegistrationIntentService.class);
        startService(intent);
    }
}
