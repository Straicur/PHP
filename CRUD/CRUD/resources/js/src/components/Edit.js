import React{useEffect,useState} from "react";
import { Link , useHistory ,useParams} from "react-router-dom";
import AppContainer from './AppContainer';
import api from '../api';
const Edit = ()=>{
    const{id}=useParams();
    const history=useHistory();
    const [loading,setLoading]=useState(false);
    const [title,setTitle]=useState('');
    const [description,setDescription]=useState('');
    const onAddSubmit= async()=>{
        setLoading(true);
        try{
            await api.updatePost({
                title,description
            },id);
            history.push("/");

        }
        catch(err){
            aler
        }
        finally{
            setLoading(false);
        }

    };
    useEffect(()=>{
        api.getOnePost(id).then(res=>{
            const result= res.data;
            const post = result.data;
            setTitle(post.title);
            setDescription(post.description);
        })
    },[])
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
                    <button type="submit"className="btn btn-success" onClick={onAddSubmit} disabled={loading}>{loading ? "Loading..." :"Edit"}</button>
                </div>
            </form>
        </AppContainer>
    )
}
export default Edit;