import { computed } from 'vue'
import moment from 'moment'

export default function useFilteredTimeSlots(rawTimeSlots, formattedDate, timeSlotExceptions) {
    return computed(() => {
        return rawTimeSlots.value.filter(slot => {
            let slotDateTime = moment(`${formattedDate.value} ${slot.start}`, 'MMMM Do, YYYY h:mm a');
            let bidEndTime = slotDateTime.clone().subtract(1, 'hours');

            let isAfterBidEndTime = bidEndTime.isAfter(moment());

            let isInExceptions = timeSlotExceptions.value.some(exception => {
                let exceptionDate = moment(exception.date).format('MMMM Do, YYYY');
                let exceptionStart = moment(exception.start_time, 'HH:mm:ss').format('h:mm a');
                let exceptionEnd = moment(exception.end_time, 'HH:mm:ss').format('h:mm a');

                return formattedDate.value === exceptionDate &&
                    slot.start === exceptionStart &&
                    slot.end === exceptionEnd;
            });

            return isAfterBidEndTime && !isInExceptions;
        });
    })
}
