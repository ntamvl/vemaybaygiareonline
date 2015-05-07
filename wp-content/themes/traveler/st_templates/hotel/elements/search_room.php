<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Hotel search room
 *
 * Created by ShineTheme
 *
 */
$default=array(
    'dropdown_style'=>'number',
    'style'=>'horizon'
);

$adult_num=STInput::get('adult_num',1);
$child_num=STInput::get('child_num',0);
$room_num=STInput::get('room_num_search',1);

if(isset($attr) and is_array($attr)){
    extract(wp_parse_args($attr,$default));
}else{
    extract($default);
}

if($style=="vertical")
{

    ?>
        <div class="search_room_alert"></div>
    <!--    Vertical Search Form-->
        <div class="booking-item-dates-change">
            <form>
                <?php wp_nonce_field('room_search','room_search')?>
                <input type="hidden" name="action" value="ajax_search_room">
                <div class="input-daterange" data-date-format="<?php echo TravelHelper::get_js_date_format()?>">
                    <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                        <label><?php st_the_language('check_in')?></label>
                        <input placeholder="<?php echo TravelHelper::get_js_date_format()?>" class="form-control" value="<?php echo STInput::get('start') ?>" name="start" type="text">
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                        <label><?php st_the_language('check_out')?></label>
                        <input placeholder="<?php echo TravelHelper::get_js_date_format()?>" class="form-control" value="<?php echo STInput::get('end') ?>" name="end" type="text">
                    </div>
                </div>
                <div class="form-group form-group-select-plus">
                    <label><?php st_the_language('rooms')?></label>
                    <?php if($dropdown_style=='number'):?>
                        <div class="btn-group btn-group-select-num <?php echo ($room_num>3)?'hidden':false ?>" data-toggle="buttons">
                            <label class="btn btn-primary <?php echo ($room_num==1)?'active':false ?>">
                                <input type="radio" value="1" name="adult_num_opt">1</label>
                            <label class="btn btn-primary <?php echo ($room_num==2)?'active':false ?>">
                                <input type="radio" value="2" name="adult_num_opt">2</label>
                            <label class="btn btn-primary <?php echo ($room_num==3)?'active':false ?>">
                                <input type="radio" value="3" name="adult_num_opt">3</label>
                            <label class="btn btn-primary">
                                <input type="radio" value="4" name="adult_num_opt">3+</label>
                        </div>
                    <?php endif; ?>
                    <select name="room_num_search" class=" form-control <?php if($dropdown_style=='number' and $room_num<4) echo "hidden";?>">
                        <?php
                        for($i=1;$i<9;$i++){
                            $select=selected($i,$room_num);
                            echo '<option '.$select.' value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group form-group-select-plus">
                    <label><?php st_the_language('adults')?></label>
                    <?php if($dropdown_style=='number'):?>
                        <div class="btn-group btn-group-select-num <?php echo ($adult_num)>3?'hidden':false ?>" data-toggle="buttons">
                            <label class="btn btn-primary <?php echo ($adult_num==1)?'active':false ?>">
                                <input type="radio" value="1" name="adult_num_opt">1</label>
                            <label class="btn btn-primary <?php echo ($adult_num==2)?'active':false ?>">
                                <input type="radio" value="2" name="adult_num_opt">2</label>
                            <label class="btn btn-primary <?php echo ($adult_num==3)?'active':false ?>">
                                <input type="radio" value="3" name="adult_num_opt">3</label>
                            <label class="btn btn-primary">
                                <input type="radio" value="4" name="adult_num_opt">3+</label>
                        </div>
                    <?php endif; ?>
                    <select name="adult_num" class="form-control <?php if($dropdown_style=='number' and $adult_num<4) echo "hidden";?>">

                        <option value=""><?php st_the_language('__select__')?></option>
                        <?php
                        $max=st()->get_option('hotel_max_adult',14);
                        for($i=1;$i<=$max;$i++){
                            $select=selected($i,STInput::get('adult_num',1));
                            echo "<option {$select} value='{$i}'>{$i}</option>";
                        }?>
                    </select>
                </div>
                <div class="form-group form-group-select-plus">
                    <label><?php st_the_language('children')?></label>
                    <?php if($dropdown_style=='number'):?>
                        <div class="btn-group btn-group-select-num <?php echo ($child_num)>3?'hidden':false ?>" data-toggle="buttons">
                            <label class="btn btn-primary <?php echo ($child_num)==0?'active':false?>">
                                <input type="radio" value="0" name="options">0</label>
                            <label class="btn btn-primary <?php echo ($child_num)==1?'active':false?>">
                                <input type="radio" value="1" name="options">1</label>
                            <label class="btn btn-primary <?php echo ($child_num)==2?'active':false?>">
                                <input type="radio" value="2" name="options">2</label>
                            <label class="btn btn-primary">
                                <input type="radio" value="3" name="options">2+</label>
                        </div>
                    <?php endif; ?>
                    <select name="child_num"
                            class="form-control <?php if($dropdown_style=='number' and $child_num<3) echo "hidden";?>">

                        <option value=""><?php st_the_language('__select__')?></option>
                        <?php

                        $max=st()->get_option('hotel_max_child',14);
                        for($i=0;$i<=$max;$i++){

                            $select=selected($i,STInput::get('child_num',0));
                            echo "<option {$select} value='{$i}'>{$i}</option>";
                        }?>
                    </select>
                </div>


                <div class="text-right">
                    <a href="#" onclick="return false" class="btn btn-primary btn-do-search-room"><?php st_the_language('search')?></a>
                    <a href="#" onclick="return false" class="btn  btn-clr-search-room"><?php st_the_language('clear')?></a>

                </div>
            </form>
        </div>
<!--    End Vertical Search Form-->
    <?php
}else
{

?><div class="search_room_alert "></div>
<div class="booking-item-dates-change">
    <form >

        <?php wp_nonce_field('room_search','room_search')?>
        <input type="hidden" name="action" value="ajax_search_room">
        <div class="row">
            <div class="col-md-6">
                <div class="input-daterange" data-date-format="<?php echo TravelHelper::get_js_date_format()?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                <label><?php st_the_language('check_in')?></label>
                                <input placeholder="<?php echo TravelHelper::get_js_date_format()?>" class="form-control" value="<?php echo STInput::get('start') ?>" name="start" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                <label><?php st_the_language('check_out')?></label>
                                <input placeholder="<?php echo TravelHelper::get_js_date_format()?>" value="<?php echo STInput::get('end') ?>" class="form-control" name="end" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            <?php  $room_num_search=STInput::get('room_num_search');?>
                <div class="form-group form-group-select-plus">
                    <label><?php st_the_language('rooms')?></label>
                    <?php if($dropdown_style=='number' and $room_num_search<4):?>
                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                            <label class="btn btn-primary <?php echo (!$room_num_search or $room_num_search==1)?'active':false; ?>">
                                <input type="radio" value="1" >1</label>
                            <label class="btn btn-primary <?php echo ($room_num_search==2)?'active':false; ?>" >
                                <input type="radio" value="2" >2</label>
                            <label class="btn btn-primary <?php echo ($room_num_search==3)?'active':false; ?>">
                                <input type="radio" value="3" >3</label>
                            <label class="btn btn-primary ">
                                <input type="radio" value="4" >3+</label>
                        </div>
                    <?php endif; ?>
                    <select name="room_num_search" class="form-control <?php if($dropdown_style=='number' and  $room_num_search<4 ) echo "hidden";?>">
                        <?php
                        for($i=1;$i<9;$i++){

                            echo '<option '.selected($room_num_search,$i,false).' value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>

                </div>
            </div>
            <div class="col-md-2">
                <?php $adult_num=STInput::get('adult_num',1);?>
                <div class="form-group form-group-select-plus">
                    <label><?php st_the_language('adults')?></label>

                    <?php if($dropdown_style=='number' and $adult_num<4):?>
                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                            <label class="btn btn-primary <?php echo (!$adult_num or $adult_num==1)?'active':false; ?>">
                                <input type="radio" value="1" name="adult_num_opt">1</label>
                            <label class="btn btn-primary <?php echo ($adult_num==2)?'active':false; ?>">
                                <input type="radio" value="2" name="adult_num_opt">2</label>
                            <label class="btn btn-primary <?php echo ($adult_num==3)?'active':false; ?>">
                                <input type="radio" value="3" name="adult_num_opt">3</label>
                            <label class="btn btn-primary <?php echo ($adult_num==4)?'active':false; ?>">
                                <input type="radio" value="4" name="adult_num_opt">3+</label>
                        </div>
                    <?php endif; ?>
                    <select name="adult_num" class="form-control <?php if($dropdown_style=='number' and $adult_num<4) echo "hidden";?>">

<!--                        <option value="">--><?php //_e('-- Select --',ST_TEXTDOMAIN)?><!--</option>-->
                        <?php
                        $max=st()->get_option('hotel_max_adult',14);
                        for($i=1;$i<=$max;$i++){
                            $select=selected($adult_num,$i,false);
                            echo "<option {$select} value='{$i}'>{$i}</option>";
                        }?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group form-group-select-plus">
                    <label><?php st_the_language('children')?></label>
                    <?php if($dropdown_style=='number'):?>
                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" value="0" name="options">0</label>
                            <label class="btn btn-primary">
                                <input type="radio" value="1" name="options">1</label>
                            <label class="btn btn-primary">
                                <input type="radio" value="2" name="options">2</label>
                            <label class="btn btn-primary">
                                <input type="radio" value="3" name="options">2+</label>
                        </div>
                    <?php endif; ?>
                    <select name="child_num"
                            class="form-control <?php if($dropdown_style=='number') echo "hidden";?>">
<!--                        <option value="">--><?php //_e('-- Select --',ST_TEXTDOMAIN)?><!--</option>-->
                        <?php

                        $max=st()->get_option('hotel_max_child',14);
                        for($i=0;$i<=$max;$i++){
                            $select='';
                            if($i==0)
                            {
                                $select="selected";
                            }
                            echo "<option {$select} value='{$i}'>{$i}</option>";
                        }?>
                    </select>
                </div>
            </div>

        </div>



        <div class="text-right">
            <a href="#" onclick="return false" class="btn btn-primary btn-do-search-room"><?php st_the_language('search')?></a>
<!--            <a href="#" onclick="return false" class="btn  btn-clr-search-room">--><?php //_e('Clear',ST_TEXTDOMAIN)?><!--</a>-->

        </div>
    </form>
</div>
<?php
}
?>
