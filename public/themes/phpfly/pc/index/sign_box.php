<div class="m-checkinCalendarPrompt-box" id="sign_box" style='display: none'>
    <div class="m-checkinCalendarPrompt">
        <span class="u-icon u-icon-arrowup"></span>
        <div class="m-checkinCalendarPrompt-tip">
            <span>连续签到有更多惊喜哦</span>
        </div>
        <div class="m-checkinCalendar">
            <div class="calendar-hd">
                <span class="before"></span>
                <span>{$today}</span>
            </div>
            <div class="calendar-bd">
                <div class="calendar-week-box">
                    <span class="calendar-week">日</span>
                    <span class="calendar-week">一</span>
                    <span class="calendar-week">二</span>
                    <span class="calendar-week">三</span>
                    <span class="calendar-week">四</span>
                    <span class="calendar-week">五</span>
                    <span class="calendar-week last">六</span>
                </div>
                <div class="calendar-days">              
                        <?php 
                        foreach ($canlendars as $row) {                       
                        ?>
                            <div class="calendar-day-box 
                                 <?php
                                 if (in_array($row['date'], $signs_dates)){echo ' isSigned ';}
                                 if($row['date'] == $today){ echo ' today ';}
                                 if($row['num'] <= 0 || $row['num'] > $days){ echo ' no-nowMonth-day ';}
                                 ?>">
                                <span class="before"></span>
                                <p class="calendar-day">{$row.day}</p>
                                <span class="after"></span>
                            </div>
                        <?php } ?>                
                </div>
            </div>
        </div>
    </div>
</div>