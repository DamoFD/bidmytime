// db Monday = 1 Sunday = 7
// Calendar Sunday = 1 Saturday = 7

import { computed } from "vue";

export default function useAvailableDaysOfWeek(weekdays) {
    return computed(() => {
        return weekdays.value ? weekdays.value.map(weekday =>
            weekday.day_of_week === 7 ? 1 : weekday.day_of_week + 1
        ) : [];
    });
}


