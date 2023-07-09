import axios from 'axios'

class fetchUrl {

    static async get(url,params) {
        try {
            const response = await axios.get(url, { params });
            console.log("In fetch: ",url)
            return response.data;
        } catch (error) {
            const errorMessage = error.response.data.message;
            throw new Error(`${errorMessage}`);
        }
    }

    static async post(url,params) {
        try {
            const response = await axios.post(url,params)
            console.log("In POST fetch: ",url)
            return response.data;
        } catch (error) {
            const errorMessage = error.response.data.message;
            throw new Error(`${errorMessage}`);
        }
    }

    static async put(url,params) {
        try {
            const response = await axios.put(url,params )
            console.log("In PUT fetch: ",url)
            return response.data;
        } catch (error) {
            const errorMessage = error.response.data.message;
            throw new Error(`${errorMessage}`);
        }
    }
}
export default fetchUrl;