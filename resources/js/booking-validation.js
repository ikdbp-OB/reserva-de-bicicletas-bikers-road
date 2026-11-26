const madridTimeFormatter = new Intl.DateTimeFormat('en-GB', {
    timeZone: 'Europe/Madrid',
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    hourCycle: 'h23',
});

function pad(value) {
    return String(value).padStart(2, '0');
}

export function getMadridTimestamp(date, hour, minute) {
    const dateParts = /^(\d{4})-(\d{2})-(\d{2})$/.exec(date);
    const numericHour = Number(hour);
    const numericMinute = Number(minute);

    if (
        !dateParts ||
        hour === '' ||
        minute === '' ||
        !Number.isInteger(numericHour) ||
        !Number.isInteger(numericMinute) ||
        numericHour < 0 ||
        numericHour > 23 ||
        numericMinute < 0 ||
        numericMinute > 59
    ) {
        return NaN;
    }

    const [, year, month, day] = dateParts;
    const wallTime = Date.UTC(
        Number(year),
        Number(month) - 1,
        Number(day),
        numericHour,
        numericMinute
    );
    let timestamp = wallTime;

    for (let attempt = 0; attempt < 3; attempt++) {
        const parts = Object.fromEntries(
            madridTimeFormatter
                .formatToParts(new Date(timestamp))
                .map(({ type, value }) => [type, value])
        );
        const formattedWallTime = Date.UTC(
            Number(parts.year),
            Number(parts.month) - 1,
            Number(parts.day),
            Number(parts.hour),
            Number(parts.minute)
        );

        timestamp = wallTime - (formattedWallTime - timestamp);
    }

    const resolved = Object.fromEntries(
        madridTimeFormatter
            .formatToParts(new Date(timestamp))
            .map(({ type, value }) => [type, value])
    );

    if (
        resolved.year !== year ||
        resolved.month !== month ||
        resolved.day !== day ||
        resolved.hour !== pad(numericHour) ||
        resolved.minute !== pad(numericMinute)
    ) {
        return NaN;
    }

    return timestamp;
}

export function validateBookingRange(startTimestamp, endTimestamp, currentTimestamp = Date.now()) {
    if (!Number.isFinite(startTimestamp) || !Number.isFinite(endTimestamp)) {
        return 'invalid';
    }

    if (startTimestamp < currentTimestamp) {
        return 'past';
    }

    if (endTimestamp <= startTimestamp) {
        return 'order';
    }

    return null;
}
