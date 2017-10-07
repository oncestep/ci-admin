<?php
/**
 * Created by PhpStorm.
 * User: 15185
 * Date: 2017/8/13
 * Time: 13:20
 */


function table_output(){
    $data = array(array());
    $data_fir = $this->category_model->get_category(1);
    $col_fir = $this->get_column($data_fir);
    if($col_fir){
        foreach($col_fir as $key => $value){
            $data[] = $data_fir[$key];
            $this->draw_column(1,$data_fir[$key]);
            $data_sec = $this->category_model->get_category(2,$value);
            $col_sec = $this->get_column($data_sec);
            if($col_sec){
                foreach($col_sec as $k => $val){
                    $data[] = $data_sec[$k];
                    $this->draw_column(2,$data_sec[$k]);
                    $data_thi = $this->category_model->get_category(3,$val);
                    if($data_thi){
                        array_push($data,$data_thi);
                        foreach($data_thi as $ks => $vals){
                            $this->draw_column(3,$data_thi[$ks]);
                        }
                    }
                }
            }
        }
    }
//        return $data;
}


function get_column($data){
    $column = array();
    foreach($data as $value){
        $column[] = $value['category_id'];
    }
    return $column;
}


function draw_column($level = 0,$row)
{
    if ($level === 1) {
        echo '
        <tr>
            <td class="center">
                <span>
                    <span>' . $row["category_name"] . '</span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span></span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span></span>
                </span>
            </td>
            <td class="center">
                <span>
                    <em>' . $row["create_time"] . '</em>
                </span>
            </td>
            <td class="center">
                <span>
                    <i>' . $row["username"] . '</i>
                </span>
            </td>
            <td class="center">
                <a title="删除"><img src="<?php echo base_url(\'resource/img/base/icon_drop.gif\') ?>"/></a>
            </td>
        </tr>';
    } else if ($level === 2) {
        echo '
        <tr>
            <td class="center">
                <span>
                    <span></span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span>' . $row["category_name"] . '</span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span></span>
                </span>
            </td>
            <td class="center">
                <span>
                    <em>' . $row["create_time"] . '</em>
                </span>
            </td>
            <td class="center">
                <span>
                    <i>' . $row["username"] . '</i>
                </span>
            </td>
            <td class="center">
                <a title="删除"><img src="<?php echo base_url(\'resource/img/base/icon_drop.gif\') ?>"/></a>
            </td>
        </tr>';
    } else {
        echo '
        <tr>
            <td class="center">
                <span>
                    <span></span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span></span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span>' . $row["category_name"] . '</span>
                </span>
            </td>
            <td class="center">
                <span>
                    <em>' . $row["create_time"] . '</em>
                </span>
            </td>
            <td class="center">
                <span>
                    <i>' . $row["username"] . '</i>
                </span>
            </td>
            <td class="center">
                <a title="删除"><img src="<?php echo base_url(\'resource/img/base/icon_drop.gif\') ?>"/></a>
            </td>
        </tr>';
    }
}
