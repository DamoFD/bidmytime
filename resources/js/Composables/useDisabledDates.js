import {computed} from 'vue'
import moment from 'moment'

export default function useDisabledDates(availableDatesOfWeek, availableExceptions) {
    // List of days in week
    const allDaysOfWeek = [1, 2, 3, 4, 5, 6, 7]

    // Calculate disabled days by removing available days
    const disabledDaysOfWeek = allDaysOfWeek.filter(day =>!availableDatesOfWeek.value.includes(day))

    // Adding exceptions where there is no start_time or end_time
    const exceptionDates = availableExceptions
        .filter(exception => !exception.start_time && !exception.end_time)
        .map(exception => moment(exception.date).add(1, 'days').format('YYYY-MM-DD'))

    // Return the disabled days in required format
    return computed(() => [
        {
            repeat: {
                weekdays: disabledDaysOfWeek,
            }
        },
        ...exceptionDates
    ])
}
