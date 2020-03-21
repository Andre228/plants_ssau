import axios from "axios";

export class RequestService {


    constructor() {
    }


    update(url, _body) {
        return Promise.resolve(
            axios.patch(url, _body)
                .then((response) => {
                    return response;
                })
        );
    }

    destroy(url) {
       return Promise.resolve(axios.delete(url)
            .then((response) => {
                return response
            })
            .catch());
    }

}