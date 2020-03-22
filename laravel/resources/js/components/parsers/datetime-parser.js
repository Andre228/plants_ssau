

export class DateTimeParser {


    constructor() {

    }

    getCurrentDateTime() {
        const d = new Date();
        const ye = new Intl.DateTimeFormat('ru', { year: 'numeric' }).format(d);
        const mo = new Intl.DateTimeFormat('ru', { month: '2-digit' }).format(d);
        const da = new Intl.DateTimeFormat('ru', { day: '2-digit' }).format(d);


        const ho = new Intl.DateTimeFormat('ru', { hour: '2-digit' }).format(d);
        const mi = new Intl.DateTimeFormat('ru', { minute: '2-digit' }).format(d);
        const se = new Intl.DateTimeFormat('ru', { second: '2-digit' }).format(d);

        const published_at = `${ye}-${mo}-${da} ${ho}:${mi}:${se}`;

        return published_at;
    }
}