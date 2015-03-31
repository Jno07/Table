<?php

/**
 * HTML table
 * @author Petr Král <wertic@seznam.cz>
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @todo Only works if correct number of atributes is given.
 * @version 1.0.0
 */
class Table {

    /**
     * One-dimensional array defining the header of the table
     * @var array
     */
    private $Header;

    /**
     * Two-dimensional array defining the records (atributes in lines) of the table
     * @var array 
     */
    private $Rows;

    /**
     * Constructor of the table
     * It has parametres
     */
    public function __construct() {
        $this->Header = array();
        $this->Rows = array();
    }

    /**
     * Header setter
     * @param array $headers
     */
    function setHeader($headers) {
        $this->Header = $headers;
    }

    /**
     * Method replacing one atribute of the table
     * @param integer $x position on the x-axis
     * @param integer $y position on the y-axis
     * @param string $value new value for the atribute
     */
    function Replace($x, $y, $value) {
        $this->Rows[$x][$y] = $value;
    }

    /**
     * Method for adding new row to the table
     * @param array $record atributes
     * @param integer $position position of the new row (optional)
     */
    function addRow($record, $position = 0) {
        $count = count($this->Rows);
        if ($count == 0) {
            $this->Rows[1] = $record;
        } elseif ($position == 0 or $position > $count) {
            $this->Rows[] = $record;
        } else {
            for ($i = $count; $i >= $position; $i--) {
                $this->Rows[$i + 1] = $this->Rows[$i];
            }
            $this->Rows[$position] = $record;
        }
    }

    /**
     * Method for adding new column to the table
     * @param string $header header of the new column
     * @param array $atributes atributes
     * @param integer $position position of the new column (optional)
     */
    function addColumn($header, $atributes, $position = 0) {
        $count = count($this->Header);
        if ($position == 0 or $position > $count) {
            $this->Header[] = $header;
            foreach ($this->Rows as $key => $value) {
                $this->Rows[$key][$position] = $atributes[$key];
            }
        } else {
            for ($i = $count; $i >= $position; $i--) {
                $this->Header[$i + 1] = $this->Header[$i];
            }
            $this->Header[$position] = $header;
            $count = count($this->Rows[1]);
            foreach ($this->Rows as $key => $value) {
                for ($i = $count; $i >= $position; $i--) {
                    $this->Rows[$key][$i + 1] = $this->Rows[$key][$i];
                }
                $this->Rows[$key][$position] = $atributes[$key];
            }
        }
    }

    /**
     * Magic method printing the table on the screen
     * @return string HTML code
     */
    function __toString() {
        $output = '<table><tr>';
        foreach ($this->Header as $value) {
            $output .= '<th>' . $value . '</th>';
        }
        $output .= '</tr>';
        foreach ($this->Rows as $key => $value) {
            $output .= '<tr>';
            foreach ($this->Rows[$key] as $value2) {
                $output .= '<td>' . $value2 . '</td>';
            }
            $output .= '</tr>';
        }
        return $output;
    }

}
