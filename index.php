<?php
const API_KEY = 'f7a19678';
const API_URL = 'http://www.omdbapi.com/';
$error = '';
if (isset($_POST) && !empty($_POST)) {
    if (isset($_POST['searchMovies']) && !empty($_POST['searchMovies']) && $_POST['searchMovies'] != 'select') {
        /* Sending Curl Request for searching data */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL."?apikey=".API_KEY."&type=movie&s=".$_POST['searchMovies']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Authorization: Bearer APIKEY";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch); /* Curl Response */
        if (curl_errno($ch)) {
            $error = "Error in Fetching data. Please try after some time.";  /* Error */
        }
        curl_close($ch);
    } else {
        $error = "Please select something !"; /* Error */
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tbody tr:hover{
            background-color: #f4010112;
        }
        .center{
            text-align: center;
        }
        .submit_color{

        }
        table{
            margin: 0 auto;
            width: 60%
        }
        
        .wrapper {
            text-align: center;
            padding-top: 50px;
            position: relative;
        }
        .wrapper select {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            padding: 10px;
            border-radius: 8px;
            -moz-appearance: none;
            width:100%;
        }
        .submit_color {
            position: absolute;
            right: 0;
            padding: 12px;
            background-color: #f00;
            border: 0;
            color: #ffffff;
            font-weight: 600;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            cursor: pointer;
        }
        .wrapper.btn-wrapper::after {
            position: absolute;
            border-top: 5px solid #a6a6a6;
            border-bottom: 5px solid transparent;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            content: "";
            top: 18px;
            right: 74px;
        }
        .wrapper.btn-wrapper {
            max-width: 300px;
            width: 100%;
            margin: 40px auto 20px;
            position: relative;
            padding: 0;
        }
        table th {
            background-color: #e8e8e8;
        }
    </style>
</head>
<body>
    <h4 class="center">MOVIES SEARCH</h4>
    <form action="index.php" method="post">
        <div class="wrapper btn-wrapper">
            <select class="custom-select" name="searchMovies" >
                <option  value="select">Select</option>
                <option 
                    <?php echo (isset($_POST['searchMovies']) && $_POST['searchMovies'] == 'red' ?  'selected' :'' )?> 
                    value="red">RED</option>
                <option 
                    <?php echo (isset($_POST['searchMovies']) && $_POST['searchMovies'] == 'green' ?  'selected':'')?> 
                    value="green">GREEN</option>
                <option 
                    <?php echo (isset($_POST['searchMovies']) && $_POST['searchMovies'] == 'blue' ?  'selected':'' )?> 
                    value="blue">BLUE</option>
                <option 
                    <?php echo (isset($_POST['searchMovies']) && $_POST['searchMovies'] == 'yellow' ?  'selected':'' )?>
                    value="yellow">YELLOW</option>
            </select>
            <input class="submit_color" type="submit" value="Search">
            <p class="err center"><?php echo $error; ?></p>  
        </div>
    </form>
    <?php 
    if (isset($result) && ! empty($result)) {
        $result = json_decode($result, true); /* Decoding json response */
        if (array_key_exists('Search', $result)) { ?>
            <div class="wrapper">
                <table>
                    <thead>
                        <tr>
                            <th class="center">TITLE</th>
                            <th class="center">YEAR</th>
                            <th class="center">IMAGE</th>
                            <th class="center">FIRST WORD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result['Search'] as $value) {
                            $first_wrd = explode(' ', trim($value['Title']));/* Splitting title to extract first word */
                            ?>
                            <tr>
                                <td class="center"><?php echo $value['Title']; ?></td>                                
                                <td class="center"><?php echo $value['Year']; ?></td>
                                <td class="center"><img width="50%" height="50%" src="<?php echo $value['Poster']; ?>" title="<?php echo $value['Title']; ?>" /></td>
                                <td class="center" ><span><?php echo $first_wrd[0];?></span></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php }
    }
    ?>
</body>
</html>