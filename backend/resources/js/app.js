require('./bootstrap');

const React = require('react');
const ReactDOM = require('react-dom');

const e = React.createElement;

// console.log(e);
class VoteButton extends React.Component {
    constructor(props) {
        super(props);
        this.state = { voted: false };
    }

    render() {
        if (this.state.voted) {
            return (
                <button onClick={() => this.setState({ voted: false })}>
                    voted
                </button>
            )
        } else {
            return (
                <button onClick={() => this.setState({ voted: true })}>
                    vote
                </button>
            );
        }
    }
}
document.querySelectorAll('.vote_button_container')
    .forEach(domContainer => {
        ReactDOM.render(
            e(VoteButton),
            domContainer
        );
    });