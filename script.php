<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $number = $_POST["number"];
  $izvele = $_POST["combo"];
  date_default_timezone_set("Europe/Riga");
  $cenas = array(
    "Eksperts Andris" => 55.00,
    "Eksperts Oskars" => 70.00,
    "Video par naudu" => 29.90,
    "Video par banku" => 26.70
  );
  if (array_key_exists($izvele, $cenas)) {
    $cena = $cenas[$izvele];
    $pvn = $cena * 0.21;
    $kopcena = $cena + $pvn;
  }
  $initial = strtoupper(substr($name, 0, 1));
  $digits = substr($number, -4);
  $date = date('dmy');
  $time = date("Hi");
  $IDnum = $initial . $digits . $date . $time;
  echo "Jūsu pasūtījumam piešķirtais identifikācijas numurs ir: " . $IDnum . "<br>";
  echo "Summa apmaksai:  " . $kopcena . " EUR.";
}
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
  echo $conn->connect_error;
  die("Registrācija neizdevās: " . $conn->connect_error);
} else {
  $name = $_POST['name'];
  $number = $_POST['number'];
  $prece = $_POST['combo'];
  if (array_key_exists($prece, $cenas)) {
    $cena = $cenas[$prece];
  }
  $query = "INSERT INTO registration (name, number, prece, cena) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssd", $name, $number, $prece, $cena);
  $execval = $stmt->execute();
  if ($execval === false) {
    echo "Kļūda reģistrācijā: " . $stmt->error;
  } else {
    echo " Registrācija ir veiksmīga Datu Bāzē";
  }
  $stmt->close();
  $conn->close();
}
?>