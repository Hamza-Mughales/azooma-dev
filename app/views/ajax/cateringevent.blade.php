<div class="Azooma-popup-box" id="event-ref-box">
    <h3 class="popup-heading Azooma-head">
       <?php echo $event->name;?>
    </h3>
    <div class="popup-content">
        <div class="spacing-container"></div>
    	<table>
            <tr>
                <td width="180">
                    <?php echo Lang::get('messages.reference_id');?>:- 
                </td>
                <td>
                    <b><?php echo 'SUF000' . $event->id;?></b>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.event_title');?>
                </td>
                <td>
                    <?php echo $event->name; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.event_type');?>
                </td>
                <td>
                    <?php echo $event->type; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.number_of_guests');?>
                </td>
                <td>
                    <?php echo $event->guests; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.budget_range_person');?>
                </td>
                <td>
                    <?php echo $event->budget.' '.$country->currency; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.event_date');?>
                </td>
                <td>
                    <?php echo date('d/m/Y',strtotime($event->date)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.event_venue');?>
                </td>
                <td>
                    <?php echo $event->eventVenue; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.event_location');?>
                </td>
                <td>
                    <?php echo $event->location; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.event_time');?>
                </td>
                <td>
                    <?php echo $event->mealType; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.pref_food_cuisines');?>
                </td>
                <td>
                    <?php
                    $cuisines = explode(',', $event->cuisines);
                    $k = 0;
                    foreach ($cuisines as $csn) {
                        $k++;
                        $cuisine = DB::table('cuisine_list')->select('cuisine_Name')->where('cuisine_ID',$csn)->first();
                        echo $cuisine->cuisine_Name;
                        if ($k != count($cuisines)) {
                            echo ', ';
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.select_meal_course');?>
                </td>
                <td>
                    <?php echo $event->meals; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.select_beverage_service');?>
                </td>
                <td>
                    <?php echo $event->beverage; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Lang::get('messages.preferred_serving_style');?>
                </td>
                <td>
                    <?php echo $event->servingStyle; ?>
                </td>
            </tr>
            <?php if ($event->eventVenue == "On Site") { ?>
                <tr>
                    <td>
                        <?php echo Lang::get('messages.dining_setup');?>
                    </td>
                    <td>
                        <?php echo $event->diningSetup; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo Lang::get('messages.servicing_staff_requirements');?>
                    </td>
                    <td>
                        <?php echo $event->staffReq; ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td>
                    <?php echo Lang::get('messages.additional_reqs');?>
                </td>
                <td>
                    <?php echo $event->notes; ?>
                </td>
            </tr>
        </table>
        <div class="spacing-container"></div>
    </div>
</div>