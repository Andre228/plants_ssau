import {RequestService} from "../../../request-services/request-service";


export class PostServices {

    constructor() {
        this.requestService = new RequestService();
    }


    update(postId, _body) {
        const url = `/admin/museum/posts/${postId}`;
        return this.requestService.update(url, _body);
    }

    destroy(postId) {
        const url = `/admin/museum/posts/${postId}`;
        return this.requestService.destroy(url);
    }

    store(_body) {
        const url = `/admin/museum/posts/`;
        return this.requestService.store(url, _body);
    }

    upload(postId, _body) {
        if (postId && _body) {
            const headers = {
                "Content-Type": "multipart/form-data"
            };
            const url = `/admin/museum/posts/${postId}/upload-file`;
            return this.requestService.post(url, _body, { headers: headers });
        }
    }

}