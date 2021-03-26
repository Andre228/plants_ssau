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
            const url = `/admin/museum/posts/${postId}/upload-file`;
            return this.requestService.post(url, _body, { headers: this.getHeadersMultipart() });
        }
    }

    import(_body) {
        if (_body) {
            const url = `/admin/museum/posts/import`;
            return this.requestService.post(url, _body, { headers: this.getHeadersMultipart() });
        }
    }

    deleteMore(count) {
        const url = `/admin/museum/posts/delete/${count}`;
        return this.requestService.destroy(url);
    }

    getHeadersMultipart() {
        const headers = {
            "Content-Type": "multipart/form-data"
        };
        return headers;
    }

}