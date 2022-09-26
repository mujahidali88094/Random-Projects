package AppointmentPackage;

import AppointmentPackage.AppointmentBean;
import java.util.*;

public class CustomComparator implements Comparator<AppointmentBean> {
    @Override
    public int compare(AppointmentBean o1, AppointmentBean o2) {
        return o1.getStart().compareTo(o2.getStart());
    }
}
