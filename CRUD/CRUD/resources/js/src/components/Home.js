import React ,{useEffect,useState}from "react";
import { Link } from "react-router-dom";
import AppContainer from './AppContainer';
import api from '../api';

const Home = ()=>{
    const [posts,setPosts]=useState(null);
    const fetchPosts=()=>{
        api.getAllPosts().then(res=>{
            const data= res.data;
            setPosts(data); 
        });
    }
    useEffect(()=>{
        fetchPosts();
    },[]);
    const renderPosts = ()=>{
        if(!posts){
            return(
            <tr>
                <td colSpan="4">Loading ...</td>
            </tr>
            )
        }
        if(posts.lenght ===0){
            return(
            <tr>
                <td colSpan="4">The is no posts ...</td>

            </tr>
            )
        }
        return posts.map((post) =>{
        <tr>
            <td>{post.id}</td>
            <td>{post.ititled}</td>
            <td>{post.description}</td>
            <td>
                <Link to={`/edit/${post.id}`} className="btn btn-warning">Edit</Link>
                <button onClick={(=>{
                    api.deletePost(post.id).then(res=>{
                        console.log(res)
                    })
                    .catch(err=>{
                        alert(err)
                    })
                })} className="btn btn-danger">Delete</button>
            </td>
        </tr>
    });
    
    }
    return(
        <AppContainer title="CRUD">
            <Link to="/add" className="btn btn-primary">Go somewhere</Link>
            <div className="table-responsive">
                <table className="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    {renderPosts()}
                        
                    </tbody>
                </table>
            </div>
        </AppContainer>
    )
}
export default Home;