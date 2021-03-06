import axios from "axios";

export class RequestService {


    constructor() {
    }


    update(url, _body, headers) {
        if (url && _body) return axios.patch(url, _body, headers);
    }

    destroy(url) {
        if (url) return axios.delete(url);
    }

    store(url, _body) {
        if (url && _body) return axios.post(url, _body);
    }

    get(url, options) {
        if (url && options) {
            return axios.get(url, options)
        } else {
            return axios.get(url);
        }
    }

    post(url, _body, headers) {
        if (url && _body) return axios.post(url, _body, headers);
        else return axios.post(url, {}, {});
    }

}