/**
 * Copyright 2019 Philipp Jahoda
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
 
package test.testapplication;

import com.github.mikephil.charting.charts.BarLineChartBase;
import com.github.mikephil.charting.components.AxisBase;
import com.github.mikephil.charting.formatter.IAxisValueFormatter;

import java.util.GregorianCalendar;

/**
 * Created by philipp on 02/06/16.
 */
public class DayAxisValueFormatter implements IAxisValueFormatter
{

    private BarLineChartBase<?> chart;

    public DayAxisValueFormatter(BarLineChartBase<?> chart) {
        this.chart = chart;
    }

    @Override
    public String getFormattedValue(float value, AxisBase axis) {

        GregorianCalendar calendar = new GregorianCalendar();
        calendar.setTimeInMillis((long) value * 60000);

        int year = calendar.get(GregorianCalendar.YEAR);
        int month = calendar.get(GregorianCalendar.MONTH) + 1;
        int dayOfMonth = calendar.get(GregorianCalendar.DAY_OF_MONTH);
        int hourOfDay = calendar.get(GregorianCalendar.HOUR_OF_DAY);
        int minute = calendar.get(GregorianCalendar.MINUTE);

        return String.format("%d/%d %d:%02d", month, dayOfMonth, hourOfDay, minute);
    }
}