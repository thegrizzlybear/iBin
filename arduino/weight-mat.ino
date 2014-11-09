#include "HX711.h"
HX711 scale(A1, A0); //nova weighing machine a1 - dout,a0 - sck

float VALUE ;

void setup() {
  Serial.begin(9600);
  Serial.println("1|wait|setup");
  weight();
  //Serial.println("readings");
}



void loop()
{

  
  //crude calibration logic : uddhav arote - 6oct 2014
    
    
    float  value ;
    int flag= 0;
    int after_recalibrate_lag = 0 ;
    int negative_count = 0;
    value = (scale.get_units(1)/10) * 1.065 ;
    if (int(value) > 0 )
    {
        Serial.print("2|recalibration|nonzero-weight|");
        Serial.println(value,DEC);
       // value = (scale.get_units(1)/10) * 1.065 ;
        //Serial.println(value,DEC);
       // VALUE = int(value);
        weight(); // calibrate when the bin is kept on the mat.
        //Serial.println("The weight mat is calibrated ...");
        
        flag = 1 ;// start recording
        value = (scale.get_units(1)/10) * 1.065 ;
        //Serial.println(value,DEC);
        delay(1000) ;
    }
    while(flag) // start reading after the calbration is done
    {
        value = (scale.get_units(1)/10) * 1.065  ; // so as to cover 3 digits after decimal
        //Serial.print(value,DEC) ;
        if(value > 0)
        {
          Serial.print("3|readings|positive|") ; // initialising string object
          Serial.println(value,DEC);
          
          //Serial.println("    positive value");
           if(negative_count)
               negative_count  = 0 ; // reset the negative count value
        }
        else // modifications: uddhav 8 oct 2014; read 4 negative values before triggering the calibration logic
        {
          Serial.print ("3|readings|negative|") ; // initialising string object
          Serial.println(value,DEC);
          negative_count ++ ; // read 4 negative readings to avoid triggerring auto-calibration just after one negative reading
          if (negative_count == 4)
          { // if four negative readings, gofor recalibration
            flag = 0;
            after_recalibrate_lag =1;
            break ;
          }
        } 
          
        delay(1000);
    }
    
    if(after_recalibrate_lag)
    {
      
       after_recalibrate_lag  =0 ; // 
       scale.tare() ; // to reset the scale to zero 
    }
    Serial.print("1|wait|zero-weight|") ;
    Serial.println(value,DEC);
    
}


void weight()
{
  //Serial.println("Before setting up the scale_v:");
  //Serial.print("read_v: \t\t");
  //Serial.println();			// print a raw reading from the ADC
  scale.read();
//  Serial.print("read average_v: \t\t");
//  Serial.println();  	// print the average of 20 readings from the ADC
  scale.read_average(20);
//  Serial.print("get value_v: \t\t");
//  Serial.println();		// print the average of 5 readings from the ADC minus the tare weight (not set yet)
  scale.get_value(5);
  //Serial.print("get units_v: \t\t");
//  Serial.println();	// print the average of 5 readings from the ADC minus tare weight (not set) divided 
  scale.get_units(5);						// by the scale_ parameter (not set yet)  

  scale.set_scale(2280.f);                      // this value is obtained by calibrating the scale_ with known weights; see the README for details
  scale.tare();				        // reset the scale_ to 0

  //Serial.println("After setting up the scale_v:");

//  Serial.print("read_v: \t\t");
  //Serial.println();                 // print a raw reading from the ADC
  scale.read();
//  Serial.print("read average_v: \t\t");
  //Serial.println();       // print the average of 20 readings from the ADC
  scale.read_average(20);
//  Serial.print("get value_v: \t\t");
  //Serial.println();		// print the average of 5 readings from the ADC minus the tare weight, set with tare()
  scale.get_value(5);
//  Serial.print("get units_v: \t\t");
  //Serial.println(, 1);        // print the average of 5 readings from the ADC minus tare weight, divided 
  scale.get_units(5);						// by the scale_ parameter set with set_scale_

 // Serial.println("Readings_v:");
}
