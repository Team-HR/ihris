<?php
class ItemNumbersSorter
{
    public $arr = array();

    public function __construct($arr)
    {

        foreach ($arr as $value) {
            $id = $this->getParent($value)[0];
            if (strpos($value, "-") !== false) {
                $sub_id = $this->getParent($value)[1];
                if (strpos($value, ".") !== false) {
                    $subest_id = $this->getChild($sub_id)[0];
                    $subest_id2 = $this->getChild($sub_id)[1];
                    $data[$id][$subest_id][$subest_id2] = $value;
                    if (is_array($data[$id][$subest_id])) {
                        ksort($data[$id][$subest_id]);
                    }
                } else {
                    $data[$id][$sub_id] = $value;
                }
                ksort($data[$id], SORT_NUMERIC);
            } else {
                if (strpos($value, ".") !== false) {
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
            ksort($data,SORT_NATURAL);
        }
        // ksort($data);
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
