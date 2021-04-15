

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

        const published_at = `${ye}-${mo}-${da} ${ho}:${this.setZeroToFront(mi)}:${this.setZeroToFront(se)}`;

        return published_at;
    }

    setZeroToFront(value) {
        return (value < 10 ? '0' : '') + value;
    }

    getCurrentDate() {
        const d = new Date();
        const ye = new Intl.DateTimeFormat('ru', { year: 'numeric' }).format(d);
        const mo = new Intl.DateTimeFormat('ru', { month: '2-digit' }).format(d);
        const da = new Intl.DateTimeFormat('ru', { day: '2-digit' }).format(d);

        const currentDate = `${ye}-${mo}-${da}`;

        return currentDate;
    }

    convertDateToString(date) {

        // let formatter = new Intl.DateTimeFormat("ru", {
        //   year: 'numeric',
        //   month: '2-digit',
        //   day: '2-digit',
        //
        //   hour: "numeric",
        //   minute: "numeric",
        //   second: "numeric",
        // });
        //
        // let dataF = formatter.format(new Date(mestnoe));
        if (date) {
            const d = new Date(date);
            const ye = new Intl.DateTimeFormat('ru', { year: 'numeric' }).format(d);
            const mo = new Intl.DateTimeFormat('ru', { month: '2-digit' }).format(d);
            const da = new Intl.DateTimeFormat('ru', { day: '2-digit' }).format(d);

            let published_at = `${da}-${mo}-${ye}`;

            return published_at;
        } else {
            return this.getCurrentDate();
        }


    }
}