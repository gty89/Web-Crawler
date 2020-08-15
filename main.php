<?php
  $html = array( "Dr. Byron Gao.html", "Dr. Xiao Chen.html", "Dr. Vangelis Metsis.html");
  // They are the professors who teach me in this semester;
  $output = array( "output1.txt", "output2.txt", "output3.txt");
  $flag1 = $flag2 = false;
  for( $i = 0; $i < 3; $i += 1)
  {
    $file = fopen( $html[$i], "r");
    while( !feof($file))
    {
      $str = fgets($file);
      
      if( preg_match( "/Dr. [A-Za-z]+ [A-Z]a-z]+/", $str, $matches))
      {
        $name = substr( $matches[0], 4); //To erase "Dr. "
      }
      
      if( preg_match( "/Education/", $str) || $flag1)
      {
        $flag1 = true;
        // Accroding to the source code, the education background is not on the same line with the word "Education", so a flag is necessary to label it;
        if( preg_match( "/<p>.*<\/p>/", $str, $matches))
        {
          $education = substr( $matches[0], 3, strlen($matches[0])-7);
          $flag1 = false;
        }
      }

      if( preg_match( "/[A-Za-z]+ [A-Za-z]+ email [A-Za-z0-9_%-]+@[A-Za-z0-9_%-]+\.([A-Za-z]{1,4})/", $str, $matches))
      // The front part is the name of the professor, which is for avoiding capture other email addresses from the website.
      {
        $email = strstr( $matches[0], "email ");
        $email = substr( $email, 6); // To erase the "email "
      }

      if( preg_match( "/Research Interests/", $str) || $flag2)
      {
        $flag2 = true;
        // Accroding to the source code, the research interests is not on the same line with the word "Research Interests", so a flag is necessary to label it;
        if( preg_match( "/<p>.*<\/p>/", $str, $matches))
        //Not all the elements in the string are words or regualr sysmbles, such as abbreviations and "&".
        {
          $research = substr( $matches[0], 3, strlen($matches[0])-7);
          $research = str_replace("&amp;", "&", $research);
          $flag2 = false;
        }
      }

      if( preg_match( "/accounts\/profiles\/[A-Za-z0-9_%-]+/", $str, $matches))
      {
        $web = $matches[0];
      }
    }
    fclose($file);

    echo "\n", $name, "\n", $education, "\n", $email, "\n", $research, "\n", $web, "\n";
    //To varifying the answers by printing;

    // Now it is time to output;
    $file = fopen( $output[$i], "w+");
    
    fwrite($file, "Name: ");
    fwrite($file, $name);
    fwrite($file, "\n");
    
    fwrite($file, "Education: ");
    fwrite($file, $education);
    fwrite($file, "\n");

    fwrite($file, "Research Interests: ");
    fwrite($file, $research);
    fwrite($file, "\n");

    fwrite($file, "Email: ");
    fwrite($file, $email);
    fwrite($file, "\n");

    fwrite($file, "Webpage: https://cs.txstate.edu/");
    fwrite($file, $web);
    fwrite($file, "\n");
    // The head is: https://cs.txstate.edu/
    // Since it is a downloading website, this original address is not recorded, so I directly add the front part of it;

    fclose($file);
  }
?>