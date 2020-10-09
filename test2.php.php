<?php
$arr = [
    "ACC-1",
    "ACC-1.1",
    "ACC-1.10",
    "ACC-1.2",
    "ACC-1.20",
    "ACC-1.3",
    "ACC-1.30",
    "ACC-1.1",
    "ACC-2",
    "ACC-7",
    "ACC-7.1",
    "ACC-2.1",

];
echo "GIVEN:";
asort($arr);
echo "<pre>" . print_r($arr, true) . "</pre>";


$sorter = new ItemNumbersSorter($arr);


echo "SORTED:";
echo "<pre>" . print_r($sorter, true) . "</pre>";

class ItemNumbersSorter
{
    public $arr = array();

    public function __construct($arr)
    {
        if (!$arr) return false;
        foreach ($arr as $value) {
            $id = $this->getParent($value)[0];
            if (strpos($value, "-")) {
                $sub_id = $this->getParent($value)[1];
                if (strpos($value, ".") !== false) {
                    $subest_id = $this->getChild($sub_id)[0];
                    $subest_id2 = $this->getChild($sub_id)[1];
                    $data[$id][$subest_id][$subest_id2] = $value;
                    if (is_array($data[$id][$subest_id])) {
                        ksort($data[$id][$subest_id]);
                    }
                } else {
                    $data[$id][$sub_id][] = $value;
                }
                ksort($data[$id], SORT_NUMERIC);
            } else {
                if (strpos($value, ".")) {
                    $subest_id = $this->getChild($value)[0];
                    $subest_id2 = $this->getChild($value)[1];
                    $data[$subest_id][$subest_id2] = $value;
                    if (is_array($data[$subest_id])) {
                        ksort($data[$subest_id]);
                    }
                } else {
                    $data[$value] = $value;
                }
            }
        }
        ksort($data, SORT_NATURAL);
        // for debugging
        echo "DEBUG:";
        echo "<pre>" . print_r($data, true) . "</pre>";

        $items = array();
        foreach ($data as $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    if (is_array($item)) {
                        foreach ($item as $sub_item) {
                            $items[] = $sub_item;
                        }
                    } else
                        $items[] = $item;
                }
            } else {
                $items[] = $value;
            }
        }

        $this->arr = $items;
    }

    private function getParent($value)
    {
        if (strpos($value, "-") === false) return $value;
        return explode("-", $value);
    }
    private function getChild($value)
    {
        if (strpos($value, ".") === false) return $value;
        return explode(".", $value);
    }
}
