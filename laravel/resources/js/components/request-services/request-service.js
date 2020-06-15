import axios from "axios";

export class RequestService {


    constructor() {
    }


    update(url, _body) {
        if (url && _body) return axios.patch(url, _body);
    }

    destroy(url) {
        if (url) return axios.delete(url);
    }

    store(url, _body) {
        if (url && _body) return axios.post(url, _body)
    }

}