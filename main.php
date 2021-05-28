<?php
  $input = fopen( "input.txt", "r") or die("Unable to open file!";
  // They are the professors who teach me in this semester;
  $flag1 = $flag2 = false;
  while( !feof( $input))
  {
  	$html = fgets( $input);
    $file = fopen( $html, "r");
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
    }
    fclose($file);

    echo "\n", $name, "\n", $education, "\n", $email, "\n", $research, "\n", $web, "\n";
    //To varifying the answers by printing;

    // Now it is time to output;
    $output = $name . "_output.txt"
    $file = fopen( $output, "w+");
    
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

    fwrite($file, "Webpage: ");
    fwrite($file, $html);
    fwrite($file, "\n");

    fclose($file);
  }
?>
