import React from 'react';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import Login from './components/Login';
import Signup from './components/Signup';
import Search from './components/Search';
import Brewery from './components/Brewery';

function App() {
    return (
        <Router>
            <Switch>
                <Route path="/login" component={Login} />
                <Route path="/signup" component={Signup} />
                <Route path="/search" component={Search} />
                <Route path="/brewery/:id" component={Brewery} />
                <Route path="/" component={Login} />
            </Switch>
        </Router>
    );
}

export default App;
