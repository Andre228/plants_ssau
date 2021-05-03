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

}