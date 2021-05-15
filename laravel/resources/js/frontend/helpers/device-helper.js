export class DeviceHelper {

    constructor() {}

    static isPhone() {
        const toMatch = [
            /Android/i,
            /webOS/i,
            /iPhone/i,
            /iPad/i,
            /iPod/i,
            /BlackBerry/i,
            /Windows Phone/i
        ];

        const isPhone = toMatch.some((toMatchItem) => {
            return navigator.userAgent.match(toMatchItem);
        });

        return isPhone;
    }

    static isLandscape() {
        return window.matchMedia("(orientation: landscape)").matches;
    }

    static geo() {
        let geoPos;
        return new Promise((resolve, reject) => {
            try {
                navigator.geolocation.getCurrentPosition((geo) => {
                    geoPos = geo;
                    resolve(geoPos);
                });
            } catch(error) {
                reject(error);
            }
        });
    }

}