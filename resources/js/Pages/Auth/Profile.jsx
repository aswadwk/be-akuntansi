import React from 'react'
import Layout from '../../Shared/Layout'
import { Link } from '@inertiajs/react'

const Profile = ({ profile }) => {
    return (
        <Layout left={<></>} right={<></>}>
            <div className="card">
                <div className="card-body">
                    <h2 className="mb-4">My Account</h2>
                    <h3 className="card-title">Profile Details</h3>
                    <div className="row align-items-center">
                        <div className="col-auto"><span className="avatar avatar-xl" style={{ backgroundImage: `url(/avatars/000f.jpg)` }}></span>
                        </div>
                        <div className="col-auto"><a href="#" className="btn">
                            Change avatar
                        </a></div>
                        <div className="col-auto"><a href="#" className="btn btn-ghost-danger">
                            Delete avatar
                        </a></div>
                    </div>
                    <h3 className="card-title mt-4">Profile</h3>
                    <div className="row g-3">
                        <div className="col-md">
                            <div className="form-label">Name</div>
                            <input type="text" className="form-control" readOnly value={profile.name} />
                        </div>
                    </div>
                    <h3 className="card-title mt-4">Email</h3>
                    <p className="card-subtitle">This contact will be shown to others publicly, so choose it carefully.</p>
                    <div>
                        <div className="row g-2">
                            <div className="col-auto">
                                <input type="text" className="form-control w-auto" value={profile.email} readOnly />
                            </div>
                            <div className="col-auto"><a href="#" className="btn">
                                Change
                            </a></div>
                        </div>
                    </div>
                    <h3 className="card-title mt-4">Password</h3>
                    <p className="card-subtitle">You can set a permanent password if you don't want to use temporary login codes.</p>
                    <div>
                        <Link href="/auth/change-password" className="btn">
                            Set new password
                        </Link>
                    </div>
                </div>
            </div>
        </Layout>
    )
}

Profile.pageTitle = "Profile"

export default Profile
