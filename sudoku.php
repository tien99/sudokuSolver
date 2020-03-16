<?php
class SudokuSolver
{
  protected $grid = [];
  protected $emptySymbol;
  public static function parseString($str, $emptySymbol = "0")
  {
    $grid = str_split($str);
    foreach ($grid as &$v) {
      if ($v == $emptySymbol) {
        $v = 0;
      } else {
        $v = (int) $v;
      }
    }
    return $grid;
  }

  public function __construct($str, $emptySymbol = "0")
  {
    if (strlen($str) !== 81) {
      throw new \Exception("Error sudoku");
    }
    $this->grid = static::parseString($str, $emptySymbol);
    $this->emptySymbol = $emptySymbol;
  }

  public function solve()
  {
    try {
      $this->placeNumber(0);
      return false;
    } catch (\Exception $e) {
      return true;
    }
  }

  protected function placeNumber($pos)
  {
    if ($pos == 81) {
      throw new \Exception("Finish");
    }
    if ($this->grid[$pos] > 0) {
      $this->placeNumber($pos + 1);
      return;
    }
    for ($n = 1; $n <= 9; $n++) {
      if ($this->checkValidity($n, $pos % 9, floor($pos / 9))) {
        $this->grid[$pos] = $n;
        $this->placeNumber($pos + 1);
        $this->grid[$pos] = 0;
      }
    }
  }

  protected function checkValidity($val, $x, $y)
  {
    for ($i = 0; $i < 9; $i++) {
      if (($this->grid[$y * 9 + $i] == $val) || ($this->grid[$i * 9 + $x] == $val)) {
        return false;
      }
    }
    $startX = (int) ((int) ($x / 3) * 3);
    $startY = (int) ((int) ($y / 3) * 3);

    for ($i = $startY; $i < $startY + 3; $i++) {
      for ($j = $startX; $j < $startX + 3; $j++) {
        if ($this->grid[$i * 9 + $j] == $val) {
          return false;
        }
      }
    }
    return true;
  }

  public function display()
  {
    $str = "";
    for ($i = 0; $i < 9; $i++) {
      for ($j = 0; $j < 9; $j++) {
        $str .= $this->grid[$i * 9 + $j];
        $str .= " ";
        if ($j == 2 || $j == 5) {
          $str .= "| ";
        }
      }
      $str .= PHP_EOL;
      if ($i == 2 || $i == 5) {
        $str .=  "------+-------+------" . PHP_EOL;
      }
    }
    echo $str;
  }

  public function __toString()
  {
    foreach ($this->grid as &$item) {
      if ($item == 0) {
        $item = $this->emptySymbol;
      }
    }
    return implode("", $this->grid);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Solve Sudoku (Made by MiTiX)</title>

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

  <style type="text/css">
    html,
    body {
      background-color: #FAFAFA
    }

    table {
      border: 2px solid #000000;
    }

    td {
      border: 1px solid #000000;
      text-align: center;
      vertical-align: middle;
    }

    input {
      color: #000000;
      padding: 0;
      border: 0;
      text-align: center;
      width: 48px;
      height: 48px;
      font-size: 24px;
      background-color: #FFFFFF;
      outline: none;
    }

    input:disabled {
      background-color: #EEEEEE;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    #cell-0,
    #cell-1,
    #cell-2 {
      border-top: 2px solid #000000;
    }

    #cell-2,
    #cell-11,
    #cell-20 {
      border-right: 2px solid #000000;
    }

    #cell-18,
    #cell-19,
    #cell-20 {
      border-bottom: 2px solid #000000;
    }

    #cell-0,
    #cell-9,
    #cell-18 {
      border-left: 2px solid #000000;
    }

    #cell-3,
    #cell-4,
    #cell-5 {
      border-top: 2px solid #000000;
    }

    #cell-5,
    #cell-14,
    #cell-23 {
      border-right: 2px solid #000000;
    }

    #cell-21,
    #cell-22,
    #cell-23 {
      border-bottom: 2px solid #000000;
    }

    #cell-3,
    #cell-12,
    #cell-21 {
      border-left: 2px solid #000000;
    }

    #cell-6,
    #cell-7,
    #cell-8 {
      border-top: 2px solid #000000;
    }

    #cell-8,
    #cell-17,
    #cell-26 {
      border-right: 2px solid #000000;
    }

    #cell-24,
    #cell-25,
    #cell-26 {
      border-bottom: 2px solid #000000;
    }

    #cell-6,
    #cell-15,
    #cell-24 {
      border-left: 2px solid #000000;
    }

    #cell-27,
    #cell-28,
    #cell-29 {
      border-top: 2px solid #000000;
    }

    #cell-29,
    #cell-38,
    #cell-47 {
      border-right: 2px solid #000000;
    }

    #cell-45,
    #cell-46,
    #cell-47 {
      border-bottom: 2px solid #000000;
    }

    #cell-27,
    #cell-36,
    #cell-45 {
      border-left: 2px solid #000000;
    }

    #cell-30,
    #cell-31,
    #cell-32 {
      border-top: 2px solid #000000;
    }

    #cell-32,
    #cell-41,
    #cell-50 {
      border-right: 2px solid #000000;
    }

    #cell-48,
    #cell-49,
    #cell-50 {
      border-bottom: 2px solid #000000;
    }

    #cell-30,
    #cell-39,
    #cell-48 {
      border-left: 2px solid #000000;
    }

    #cell-33,
    #cell-34,
    #cell-35 {
      border-top: 2px solid #000000;
    }

    #cell-35,
    #cell-44,
    #cell-53 {
      border-right: 2px solid #000000;
    }

    #cell-51,
    #cell-52,
    #cell-53 {
      border-bottom: 2px solid #000000;
    }

    #cell-33,
    #cell-42,
    #cell-51 {
      border-left: 2px solid #000000;
    }

    #cell-54,
    #cell-55,
    #cell-56 {
      border-top: 2px solid #000000;
    }

    #cell-56,
    #cell-65,
    #cell-74 {
      border-right: 2px solid #000000;
    }

    #cell-72,
    #cell-73,
    #cell-74 {
      border-bottom: 2px solid #000000;
    }

    #cell-54,
    #cell-63,
    #cell-72 {
      border-left: 2px solid #000000;
    }

    #cell-57,
    #cell-58,
    #cell-59 {
      border-top: 2px solid #000000;
    }

    #cell-59,
    #cell-68,
    #cell-77 {
      border-right: 2px solid #000000;
    }

    #cell-75,
    #cell-76,
    #cell-77 {
      border-bottom: 2px solid #000000;
    }

    #cell-57,
    #cell-66,
    #cell-75 {
      border-left: 2px solid #000000;
    }

    #cell-60,
    #cell-61,
    #cell-62 {
      border-top: 2px solid #000000;
    }

    #cell-62,
    #cell-71,
    #cell-80 {
      border-right: 2px solid #000000;
    }

    #cell-78,
    #cell-79,
    #cell-80 {
      border-bottom: 2px solid #000000;
    }

    #cell-60,
    #cell-69,
    #cell-78 {
      border-left: 2px solid #000000;
    }
  </style>
</head>

<body>
  <form action="sudoku.php" method="post" style="text-align: center;">
    <div class="container">

      <h1>Solve Sudoku (Made by MiTiX)</h1>

      <table id="grid" style="margin-left:auto;margin-right:auto;">

        <tr>
          <td><input id="cell-0" name="cell-0" type="number" min="1" max="9"></td>
          <td><input id="cell-1" name="cell-1" type="number" min="1" max="9"></td>
          <td><input id="cell-2" name="cell-2" type="number" min="1" max="9"></td>

          <td><input id="cell-3" name="cell-3" type="number" min="1" max="9"></td>
          <td><input id="cell-4" name="cell-4" type="number" min="1" max="9"></td>
          <td><input id="cell-5" name="cell-5" type="number" min="1" max="9"></td>

          <td><input id="cell-6" name="cell-6" type="number" min="1" max="9"></td>
          <td><input id="cell-7" name="cell-7" type="number" min="1" max="9"></td>
          <td><input id="cell-8" name="cell-8" type="number" min="1" max="9"></td>
        </tr>

        <tr>
          <td><input id="cell-9" name="cell-9" type="number" min="1" max="9"></td>
          <td><input id="cell-10" name="cell-10" type="number" min="1" max="9"></td>
          <td><input id="cell-11" name="cell-11" type="number" min="1" max="9"></td>

          <td><input id="cell-12" name="cell-12" type="number" min="1" max="9"></td>
          <td><input id="cell-13" name="cell-13" type="number" min="1" max="9"></td>
          <td><input id="cell-14" name="cell-14" type="number" min="1" max="9"></td>

          <td><input id="cell-15" name="cell-15" type="number" min="1" max="9"></td>
          <td><input id="cell-16" name="cell-16" type="number" min="1" max="9"></td>
          <td><input id="cell-17" name="cell-17" type="number" min="1" max="9"></td>
        </tr>

        <tr>
          <td><input id="cell-18" name="cell-18" type="number" min="1" max="9"></td>
          <td><input id="cell-19" name="cell-19" type="number" min="1" max="9"></td>
          <td><input id="cell-20" name="cell-20" type="number" min="1" max="9"></td>

          <td><input id="cell-21" name="cell-21" type="number" min="1" max="9"></td>
          <td><input id="cell-22" name="cell-22" type="number" min="1" max="9"></td>
          <td><input id="cell-23" name="cell-23" type="number" min="1" max="9"></td>

          <td><input id="cell-24" name="cell-24" type="number" min="1" max="9"></td>
          <td><input id="cell-25" name="cell-25" type="number" min="1" max="9"></td>
          <td><input id="cell-26" name="cell-26" type="number" min="1" max="9"></td>
        </tr>

        <tr>
          <td><input id="cell-27" name="cell-27" type="number" min="1" max="9"></td>
          <td><input id="cell-28" name="cell-28" type="number" min="1" max="9"></td>
          <td><input id="cell-29" name="cell-29" type="number" min="1" max="9"></td>

          <td><input id="cell-30" name="cell-30" type="number" min="1" max="9"></td>
          <td><input id="cell-31" name="cell-31" type="number" min="1" max="9"></td>
          <td><input id="cell-32" name="cell-32" type="number" min="1" max="9"></td>

          <td><input id="cell-33" name="cell-33" type="number" min="1" max="9"></td>
          <td><input id="cell-34" name="cell-34" type="number" min="1" max="9"></td>
          <td><input id="cell-35" name="cell-35" type="number" min="1" max="9"></td>
        </tr>

        <tr>
          <td><input id="cell-36" name="cell-36" type="number" min="1" max="9"></td>
          <td><input id="cell-37" name="cell-37" type="number" min="1" max="9"></td>
          <td><input id="cell-38" name="cell-38" type="number" min="1" max="9"></td>

          <td><input id="cell-39" name="cell-39" type="number" min="1" max="9"></td>
          <td><input id="cell-40" name="cell-40" type="number" min="1" max="9"></td>
          <td><input id="cell-41" name="cell-41" type="number" min="1" max="9"></td>

          <td><input id="cell-42" name="cell-42" type="number" min="1" max="9"></td>
          <td><input id="cell-43" name="cell-43" type="number" min="1" max="9"></td>
          <td><input id="cell-44" name="cell-44" type="number" min="1" max="9"></td>
        </tr>

        <tr>
          <td><input id="cell-45" name="cell-45" type="number" min="1" max="9"></td>
          <td><input id="cell-46" name="cell-46" type="number" min="1" max="9"></td>
          <td><input id="cell-47" name="cell-47" type="number" min="1" max="9"></td>

          <td><input id="cell-48" name="cell-48" type="number" min="1" max="9"></td>
          <td><input id="cell-49" name="cell-49" type="number" min="1" max="9"></td>
          <td><input id="cell-50" name="cell-50" type="number" min="1" max="9"></td>

          <td><input id="cell-51" name="cell-51" type="number" min="1" max="9"></td>
          <td><input id="cell-52" name="cell-52" type="number" min="1" max="9"></td>
          <td><input id="cell-53" name="cell-53" type="number" min="1" max="9"></td>
        </tr>

        <tr>
          <td><input id="cell-54" name="cell-54" type="number" min="1" max="9"></td>
          <td><input id="cell-55" name="cell-55" type="number" min="1" max="9"></td>
          <td><input id="cell-56" name="cell-56" type="number" min="1" max="9"></td>

          <td><input id="cell-57" name="cell-57" type="number" min="1" max="9"></td>
          <td><input id="cell-58" name="cell-58" type="number" min="1" max="9"></td>
          <td><input id="cell-59" name="cell-59" type="number" min="1" max="9"></td>

          <td><input id="cell-60" name="cell-60" type="number" min="1" max="9"></td>
          <td><input id="cell-61" name="cell-61" type="number" min="1" max="9"></td>
          <td><input id="cell-62" name="cell-62" type="number" min="1" max="9"></td>
        </tr>

        <tr>
          <td><input id="cell-63" name="cell-63" type="number" min="1" max="9"></td>
          <td><input id="cell-64" name="cell-64" type="number" min="1" max="9"></td>
          <td><input id="cell-65" name="cell-65" type="number" min="1" max="9"></td>

          <td><input id="cell-66" name="cell-66" type="number" min="1" max="9"></td>
          <td><input id="cell-67" name="cell-67" type="number" min="1" max="9"></td>
          <td><input id="cell-68" name="cell-68" type="number" min="1" max="9"></td>

          <td><input id="cell-69" name="cell-69" type="number" min="1" max="9"></td>
          <td><input id="cell-70" name="cell-70" type="number" min="1" max="9"></td>
          <td><input id="cell-71" name="cell-71" type="number" min="1" max="9"></td>
        </tr>

        <tr>
          <td><input id="cell-72" name="cell-72" type="number" min="1" max="9"></td>
          <td><input id="cell-73" name="cell-73" type="number" min="1" max="9"></td>
          <td><input id="cell-74" name="cell-74" type="number" min="1" max="9"></td>

          <td><input id="cell-75" name="cell-75" type="number" min="1" max="9"></td>
          <td><input id="cell-76" name="cell-76" type="number" min="1" max="9"></td>
          <td><input id="cell-77" name="cell-77" type="number" min="1" max="9"></td>

          <td><input id="cell-78" name="cell-78" type="number" min="1" max="9"></td>
          <td><input id="cell-79" name="cell-79" type="number" min="1" max="9"></td>
          <td><input id="cell-80" name="cell-80" type="number" min="1" max="9"></td>
        </tr>

      </table>

      <input type="submit" style="width: 100%;" value="Solve" name="solve"><br>

    </div>
  </form>
  <?php
  if (isset($_POST["solve"])) {
    $input = "000000000000000000000000000000000000000000000000000000000000000000000000000000000";
    for ($i = 0; $i < 81; $i++) {
      if (isset($_POST["cell-{$i}"])) {
        $input[$i] = $_POST["cell-{$i}"];
      }
    }
  ?>
    <form style="text-align: center;">
      <div class="container">

        <h1>Input</h1>

        <table id="grid" style="margin-left:auto;margin-right:auto;">
          <?php
          $i = 0;
          while ($i < 81) {
            if ($i % 9 == 0) {
          ?>
              <tr>
              <?php
            }
            $id = "cell-{$i}";
              ?>
              <td><input id="<?php echo $id; ?>" type="number" min="1" max="9" <?php if ($input[$i] != 0) { ?> value="<?php echo $input[$i]; ?>" disabled <?php } ?>></td>
              <?php
              if ($i % 9 == 8) {
              ?>
              </tr>
          <?php
              }
              $i++;
            }
          ?>
        </table>
      </div>
    </form>
    <?php
    $solver = new SudokuSolver($input);
    $solver->solve();
    $output = (string) $solver;
    ?>

    <form style="text-align: center;">
      <div class="container">

        <h1>Output</h1>

        <table id="grid" style="margin-left:auto;margin-right:auto;">
          <?php
          $i = 0;
          while ($i < 81) {
            if ($i % 9 == 0) {
          ?>
              <tr>
              <?php
            }
            $id = "cell-{$i}";
              ?>
              <td><input id="<?php echo $id; ?>" type="number" min="1" max="9" value="<?php echo $output[$i]; ?>" disabled></td>
              <?php
              if ($i % 9 == 8) {
              ?>
              </tr>
        <?php
              }
              $i++;
            }
          }
        ?>
        </table>
      </div>
    </form>

</body>

</html>

<br>Made by @MiTiX
<br>source: https://rosettacode.org/wiki/Sudoku
<br>source: https://gist.github.com/thebinarypenguin/4d45ffe87096e508800b5d11544bf2fa