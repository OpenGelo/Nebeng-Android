package com.sumarnakreatip.uiiot;

/**
 * Class DrawerItem
 *
 * @author  Sanadhi Sutandi, Suryo
 * @version 0.3
 * @since   2016-03
 */

public class DrawerItem {

    String ItemName;
    int imgResID;

    public DrawerItem(String itemName, int imgResID) {
        super();
        ItemName = itemName;
        this.imgResID = imgResID;
    }

    public String getItemName() {
        return ItemName;
    }

    public void setItemName(String itemName) {
        ItemName = itemName;
    }

    public int getImgResID() {
        return imgResID;
    }

    public void setImgResID(int imgResID) {
        this.imgResID = imgResID;
    }

}
