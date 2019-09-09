package test.testapplication;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.text.method.ScrollingMovementMethod;
import android.widget.TextView;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;

public class OSSLicense extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_osslicense);

        try {
            InputStream inputStream = getResources().getAssets().open("LICENSE-2.0.txt");
            ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();

            int i;
            while ((i = inputStream.read()) != -1) {
                byteArrayOutputStream.write(i);
            }

            ((TextView)findViewById(R.id.licenseView)).setText(new String(byteArrayOutputStream.toByteArray()));
            inputStream.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
