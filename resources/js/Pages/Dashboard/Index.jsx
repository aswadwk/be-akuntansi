import React from "react";
import Layout from "../../Shared/Layout";

const index = ({ currentUser }) => {
    console.log(currentUser);

    return (
        <Layout>
            <div className="row row-deck row-cards"></div>
        </Layout>
    );
};

export default index;
