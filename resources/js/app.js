import './bootstrap';
import localeEn from 'air-datepicker/locale/en';

window.AirDatepicker = AirDatepicker;
window.airDatepickerLocaleEn = localeEn;


window.datepickerComponent = function (elementId, wireModel)
{
    return {
        datepicker: null,
            initDatepicker() {
            this.datepicker = new AirDatepicker(`#${elementId}`, {
                timepicker: true,
                autoClose: true,
                isMobile: true,
                locale: airDatepickerLocaleEn,
                showOtherMonths: false,
                dateFormat: 'yyyy-MM-dd',
                timeFormat: 'HH:mm',
                onSelect: (params) => {
                    const val = params.formattedDate ? params.formattedDate : null;
                    this.$wire.set(wireModel, val);
                }
            });
        }
    }
}
