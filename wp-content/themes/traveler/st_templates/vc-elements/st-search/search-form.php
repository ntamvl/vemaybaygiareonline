<?php
extract($data);
$list_tab = st()->get_option('search_tabs');
?>


<div class="search-tabs search-tabs-bg <?php if(!empty($class)) echo esc_attr($class) ?>  <?php if($st_box_shadow=='no') echo 'no-boder-search '; else echo 'boder-search'; ?>">
    <div class="tabbable">
        <?php if(!empty($title)):?>
            <h1 class="text-white"><?php if(!empty($title)) echo balanceTags($title) ?></h1>
        <?php endif;?>
        <ul class="nav nav-tabs" id="myTab">
            <?php
            if(!empty($list_tab)):
                $i=0;
                foreach($list_tab as $k => $value){
                    if(!empty($value['check_tab']) and $value['check_tab'] == 'on') {
                        ?>
                        <li <?php if($i == 0) echo 'class="active"'; ?>>
                            <a href="#tab-<?php echo sanitize_title( $value[ 'tab_name' ] )?>"
                               data-toggle="tab"><?php echo st_handle_icon_tag( $value[ 'tab_icon' ] ) ?>
                                <span><?php echo esc_html( $value[ 'title' ] )?></span></a>
                        </li>
                    <?php
                    }
                $i++;
                }
            endif;
            ?>
        </ul>
        <div class="tab-content">
            <?php
                if(!empty($list_tab)):
                    $i=0;
                    foreach( $list_tab  as $k => $v){
                        $active=false;
                        if($i==0){
                            $active = 'active in';
                        }
                        $i++;
                        $default=array(
                            'st_style_search' =>$st_style_search,
                            'st_direction'=>'horizontal',
                            'st_box_shadow'=>$st_box_shadow,
                            'st_search_tabs'=>'yes',
                            'st_title_search'=>$v['tab_search_title'],
                            'field_size'    =>'lg',
                        );
                        $html='';
                        if(!empty($v['check_tab']) and $v['check_tab'] == 'on'){
                            switch($v['tab_name']){
                                case "hotel":
                                    $html .='<div class="tab-pane fade '.$active.'" id="tab-hotel">';
                                    $html .= st()->load_template('search/content-search','hotel',$default);
                                    $html .='</div>';
                                    break;
                                case "cars":
                                    $html .='<div class="tab-pane fade '.$active.'" id="tab-cars">';
                                    $html .= st()->load_template('search/content-search','cars',$default);
                                    $html .='</div>';
                                    break;
                                case "rental":
                                    $html .='<div class="tab-pane fade '.$active.'" id="tab-rental">';
                                    $html .= st()->load_template('search/content-search','rental',$default);
                                    $html .='</div>';
                                    break;
                                case "tour":
                                    $html .='<div class="tab-pane fade '.$active.'" id="tab-tour">';
                                    $html .= st()->load_template('search/content-search','tours',$default);
                                    $html .='</div>';
                                    break;
                                case "activities":
                                    $html .='<div class="tab-pane fade '.$active.'" id="tab-activities">';
                                    $html .= st()->load_template('search/content-search','activities',$default);
                                    $html .='</div>';
                                    break;
                            }
                        }
                        echo balanceTags($html);
                    }
                endif;
            ?>
        </div>
    </div>
</div>