jQuery(document).ready(function($) {
    $('.owac-calendar-container').on("click", ".owac-next.owac-arrow", function() {
        //deal with updating the index of the calendar slide
        let children = $(".owac-track").children();
        let index = parseInt(children.attr("data-owac-index"));
        index+=1;
        
        //allocate more room for the incoming calendars
        $(".owac-track").append(`<div class="owac-slide" data-owac-index="${index}" aria-hidden="true" style="width: 506px; height: 344px;" tabindex="-1"><div><table class="main owac owac_google_events" style="background-color: rgb(255, 255, 255) !important; width: 100%; display: inline-block;"><tbody><tr class="month_title"><td colspan="8" align="center"><h3 style="background-color: #FFFFFF !important;; color: #000000 !important;;"> April 2020</h3></td></tr><tr class="day_title"><th><span>S</span></th><th><span>S</span></th><th><span>M</span></th><th><span>T</span></th><th><span>W</span></th><th><span>T</span></th><th><span>F</span></th><th><span class="price">Price</span></th></tr><tr class="day_row"><td><span class="owaccatdec" style="background-color:#FF0000">28</span></td><td><span class="owaccatdec" style="background-color:#FF0000">29</span></td><td><span class="owaccatdec" style="background-color:#FF0000">30</span></td><td><span class="owaccatdec" style="background-color:#FF0000">31</span></td><td><span class="owaccatdec" style="background-color:#FF0000">1</span></td><td><span class="owaccatdec" style="background-color:#FF0000">2</span></td><td><span class="owaccatdec" style="background-color:#FF0000">3</span></td><td class="disable"><span class="price">€500</span></td></tr><tr class="day_row"><td class="disable"><span>4</span></td><td class="disable"><span>5</span></td><td class="disable"><span>6</span></td><td class="disable"><span>7</span></td><td class="disable"><span>8</span></td><td class="disable"><span>9</span></td><td class="disable"><span>10</span></td><td class="disable"><span class="price">€600</span></td></tr><tr class="day_row"><td class="disable"><span>11</span></td><td class="disable"><span>12</span></td><td class="disable"><span>13</span></td><td class="disable"><span>14</span></td><td class="disable"><span>15</span></td><td class="disable"><span>16</span></td><td class="disable"><span>17</span></td><td class="disable"><span class="price">€</span></td></tr><tr class="day_row"><td class="disable"><span>18</span></td><td class="disable"><span>19</span></td><td class="disable"><span>20</span></td><td class="disable"><span>21</span></td><td class="disable"><span>22</span></td><td class="disable"><span>23</span></td><td class="disable"><span>24</span></td><td class="disable"><span class="price">€</span></td></tr><tr class="day_row"><td class="disable"><span>25</span></td><td class="disable"><span>26</span></td><td class="disable"><span>27</span></td><td class="disable"><span>28</span></td><td class="disable"><span>29</span></td><td class="disable"><span>30</span></td><td class="disable extradays"><span>1</span></td><td class="disable extradays"><span class="price">€</span></td></tr></tbody></table></div></div>`);
        let width = $(".owac-track").css('width');
        calWidth = parseInt(width);
        calWidth += 530;
        calWidth = calWidth + "px";
        $(".owac-track").css('width', calWidth);
        
    });
});
