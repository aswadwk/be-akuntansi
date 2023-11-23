import React, { useCallback, forwardRef } from "react";
import { CustomContentProps, SnackbarContent, useSnackbar } from "notistack";
import { IconCheck } from "@tabler/icons-react";

interface ReportCompleteProps extends CustomContentProps {
    allowDownload?: boolean;
}

const Success = forwardRef(({ id, ...props }, ref) => {
    const { closeSnackbar } = useSnackbar();

    const handleDismiss = useCallback(() => {
        closeSnackbar(id);
    }, [id, closeSnackbar]);

    return (
        <SnackbarContent ref={ref}>
            <div className="alert alert-success alert-dismissible" role="alert">
                <div className="d-flex">
                    <div>
                        <IconCheck className="pe-2 text-success" width={34} />
                    </div>
                    <div>
                        <h4 className="alert-title">Wow! Everything worked!</h4>
                        <div className="text-muted">{props.message}</div>
                    </div>
                </div>
                <a
                    className="btn-close"
                    onClick={handleDismiss}
                    aria-label="close"
                ></a>
            </div>
        </SnackbarContent>
    );
});

Success.displayName = "Success";

export default Success;
