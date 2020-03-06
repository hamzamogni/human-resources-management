import axios from 'axios';

export default() => {
    let baseURL = process.env.NODE_ENV === "production"
                    ? "http://platform.ecdh.ma"
                    : "http://127.0.0.1:8000"
    return axios.create({
        baseURL: baseURL,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
}
