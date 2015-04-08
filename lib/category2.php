<?php

class Category2 {
    /* database connection */

    private $con = null;
    /* category array is creating when object is created */
    var $categories = array();
    /* input type either checkbox or radio default checkbox */
    var $inputType = 'checkbox';
    /* already selected values */
    var $checked = array();
    /* Selectd value */
    var $selected = '';

    function __construct($con) {
        $this->con = $con;
        $query = "SELECT category_id,category_name,category_parent_id FROM categories";
        $ulLiStringesult = mysqli_query($this->con, $query);
        $data = array();
        while ($ulLiStringow = mysqli_fetch_assoc($ulLiStringesult)) {
            $data[$ulLiStringow['category_id']] = $ulLiStringow;
        }
        $this->categories = $data;
    }

    /*
     * Create category array to tree array 
     * @return array(); 
     */

    function getTreeArray($src_arr = array()) {
        $tree = array();
        if (is_array($src_arr) AND count($src_arr) < 1) {
            $src_arr = $this->categories;
        }
        foreach ($src_arr AS $category) {
            $tree[$category['category_parent_id']][$category['category_id']] = $category;
        }
        return $tree;
    }

    /*
     * Create <ul> <li> from Tree Array
     * Expected paramiter $categoryArray(array), $parent_id(parent_category_id)
     * @return string;
     *
     */

    function getUlLiFromTreeArray($categoryArray, $parent_id) {
        $inputString = '';
        foreach ($categoryArray as $category) {
            if ($category['category_parent_id'] == $parent_id) {

                $inputString .= '<li title="' . $category['category_name'] . '">';
                $inputString .= "<a></a>";
                if (in_array($category['category_id'], $this->checked)) {
                    $inputString .= '<input  checked="checked"   type="' . $this->inputType . '" name="categories[]" value="' . $category['category_id'] . '" />' . $category['category_name'];
                } else {
                    $inputString .= '<input  type="' . $this->inputType . '" name="categories[]" value="' . $category['category_id'] . '" />' . $category['category_name'];
                }
                $inputString .= '<ul>';
                $inputString .= $this->getUlLiFromTreeArray($categoryArray, $category['category_id']);
                $inputString .= '</ul></li>';
            }
        }
        return ($inputString == '' ? '' : "" . $inputString );
    }

    /*
     * Create checkbox or radio box to category operations  
     * Expected $parent_id(parent_category_id)
     * @return string;
     */

    function viewTree($parent_id = 0) {

        return $this->getInputBoxFromTreeArray($this->categories, $parent_id);
    }

    /* ======================Start beckend function for sq-group========================= */

    /*
     * Create checkbox or radio box from Tree Array
     * Expected paramiter $categoryArray(array), $parent_id(parent_category_id)
     * @return string;
     *
     */

    function getInputBoxFromTreeArray($categoryArray, $parent_id) {
        $inputString = '';
        foreach ($categoryArray as $category) {
            if ($category['category_parent_id'] == $parent_id) {

                $inputString .= '<li title="' . $category['category_name'] . '">';
                $inputString .= "<a></a>";
                if (in_array($category['category_id'], $this->checked)) {
                    $inputString .= '<input  checked="checked"   type="' . $this->inputType . '" name="categories[]" value="' . $category['category_id'] . '" />' . $category['category_name'];
                } else {
                    $inputString .= '<input  type="' . $this->inputType . '" name="categories[]" value="' . $category['category_id'] . '" />' . $category['category_name'];
                }


                $inputString .= '<ul>';

                $inputString .= $this->getUlLiFromTreeArray($categoryArray, $category['category_id']);
                $inputString .= '</ul></li>';
            }
        }
        return ($inputString == '' ? '' : "" . $inputString );
    }

    /* ======================End beckend function for sq-group========================= */


    /* ======================start category dropdown ========================= */
    /*
     * Create Select or combobox
     * Expected $parent_id(parent_category_id)
     * @return string;
     */

    function viewDropdown($parent_id = 0) {

        return $this->getOptionFromTreeArray($this->categories, $parent_id);
    }

    /*
     * get options of select 
     * Expected paramiter $categoryArray(array), $parent_id(parent_category_id)
     * @return string;
     *
     */

    function getOptionFromTreeArray($categoryArray, $parent_id) {
        $optionString = '';
        foreach ($categoryArray as $category) {
            if ($category['category_parent_id'] == $parent_id) {

                if ($category['category_id'] == $this->selected) {
                    $optionString .= ' <option value="' . $category['category_id'] . '" selected="selected">';
                } else {
                    $optionString .= ' <option value="' . $category['category_id'] . '">';
                }

                $optionString .= $category['category_name'];
                $optionString .= '</option>';

                $optionString .= $this->getGroupFromTreeArray($categoryArray, $category['category_id']);
            }
        }
        return ($optionString == '' ? '' : "" . $optionString );
    }

    /*
     * get option group
     * Expected paramiter $categoryArray(array), $parent_id(parent_category_id)
     * @return string;
     *
     */

    function getGroupFromTreeArray($categoryArray, $parent_id, $level = '') {
        $optionString = '';
        $level .='|- -';
        foreach ($categoryArray as $category) {
            if ($category['category_parent_id'] == $parent_id) {

                if ($category['category_id'] == $this->selected) {
                    $optionString .= ' <option value="' . $category['category_id'] . '" selected="selected">';
                } else {
                    $optionString .= ' <option value="' . $category['category_id'] . '">';
                }

                $optionString .= $level . $category['category_name'];
                $optionString .= '</option>';

                $optionString .= $this->getGroupFromTreeArray($categoryArray, $category['category_id'], $level);
            }
        }
        return ($optionString == '' ? '' : "" . $optionString );
    }

    /* ======================end category dropdown ========================= */

    /* ======================start category one way parents  ========================= */
    /*
     * Create Select or combobox
     * @paramiter $start = 0, $end=0, $return_filed='category_id'
     * @return string;
     */

    function getParents($start = 0, $end = 0) {

        return $this->getParentsFromTreeArray($start, $end);
    }

    /*
     * getParentsFromTreeArray 
     * @paramiter $parent_id = 0, $end_category_id=0
     * @return $string;
     */

    function getParentsFromTreeArray($parent_id, $end_category_id, $return = array()) {

        if (!isset($this->categories[$end_category_id]) OR $parent_id == $end_category_id) {
            return $return;
        }
        $return[$end_category_id] = $this->categories[$end_category_id];
        return $this->getParentsFromTreeArray($parent_id, $this->categories[$end_category_id]['category_parent_id'], $return);
    }

    /* ======================end  category one way parents ========================= */

    /* ======================start  category one way child ========================= */
    /*
     * Create Select or combobox
     * @paramiter $start = 0, $end=0, $return_filed='category_id'
     * @return string;
     */

    function getChilds($start = 0) {

        return $this->getChildsFromTreeArray($start);
    }

    /*
     * get options of select 
     * Expected paramiter $categoryArray(array), $parent_id(parent_category_id)
     * @return string;
     *
     */

    function getChildsFromTreeArray($parent_id) {
        $return = array();
        $tree = $this->getTreeArray($this->categories);
        if (isset($tree[$parent_id])) {
            foreach ($tree[$parent_id] as $category) {
                $return[$category['category_id']] = $category;
                $return = $this->getGrandchildsFromTreeArray($category['category_id'], $return);
            }
        }

        return $return;
    }

    /*
     * getGrandchildsFromTreeArray
     * get option group
     * Expected paramiter $categoryArray(array), $parent_id(parent_category_id)
     * @return string;
     *
     */

    function getGrandchildsFromTreeArray($parent_id, $return = array()) {
        $tree = $this->getTreeArray($this->categories);
        if (isset($tree[$parent_id])) {
            foreach ($tree[$parent_id] as $category) {
                $return[$category['category_id']] = $category;
                $return= $this->getGrandchildsFromTreeArray($category['category_id'], $return);
            }
        }

        return $return;
    }

    /* ======================end  category one way child ========================= */
}

?>