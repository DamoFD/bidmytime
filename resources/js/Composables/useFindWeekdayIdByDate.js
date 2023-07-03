export default function useFindWeekdayIdByDate(weekdays) {
    return (date) => {
        const dayOfWeek = date.getDay() + 1;
        const weekday = weekdays.value.find(weekday => weekday.day_of_week === dayOfWeek);
        return weekday ? weekday.id : null;
    }
}
