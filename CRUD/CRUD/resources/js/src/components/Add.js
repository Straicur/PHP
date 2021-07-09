import React from "react";
import { Link , useHistory} from "react-router-dom";
import AppContainer from './AppContainer';
import api from '../api';
const Add = ()=>{
    const history=useHistory();
    const [loading,setLoading]=useState(false);
    const [title,setTitle]=useState('');
    const [description,setDescription]=useState('');
    const onAddSubmit= async()=>{
        setLoading(true);
        try{
            await api.addPost({
                title,description
            })
            history.push("/");

        }
        catch(err){
            aler
        }
        finally{
            setLoading(false);
        }

    };
    return(
        <AppContainer title="Add Post">
            <form>
                <div className="form-group">

                    <label>Title</label>
                    <input type="text" className="form-control" value={title} onChange={setTitle(e.target.value)}/>
                </div> 
                <div className="form-group">
                    <label>Description</label>
                    <textarea type="text" className="form-control" value={description} onChange={setDescription(e.target.value)}></textarea>
                </div>
                <div className="form-group">
                    <button type="submit"className="btn btn-success" onClick={onAddSubmit} disabled={loading}>{loading ? "Loading..." :"ADD"}</button>
                </div>
            </form>
        </AppContainer>
    )
}
export default Add;