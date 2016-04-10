package com.sumarnakreatip.uiiot;

import android.app.Application;
import android.app.Fragment;
import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class About extends Fragment {

    ImageView ivIcon;
    TextView tvItemName;

    Context layout;

    public static final String IMAGE_RESOURCE_ID = "iconResourceID";
    public static final String ITEM_NAME = "itemName";

    public About() {
        //this.et=user;
        //this.regid=reg;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.about, container, false);
        ivIcon = (ImageView) view.findViewById(R.id.frag3_icon);
        tvItemName = (TextView) view.findViewById(R.id.frag3_text);
        return view;
    }

}
