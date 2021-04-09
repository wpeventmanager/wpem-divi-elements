// External Dependencies
import React, { Component } from 'react';

class EventListing extends Component {

    static slug = 'wpem_event_listing';

    render() {

        return (
            <>

                {this.props.content}

            </>
        );
    }
}

export default EventListing;
