import React, { useCallback, forwardRef } from "react";
import { CustomContentProps, SnackbarContent, useSnackbar } from "notistack";
import { IconAlertTriangle } from "@tabler/icons-react";

interface ReportCompleteProps extends CustomContentProps {
    allowDownload?: boolean;
}

const Danger = forwardRef(({ id, ...props }, ref) => {
    const { closeSnackbar } = useSnackbar();

    const handleDismiss = useCallback(() => {
        closeSnackbar(id);
    }, [id, closeSnackbar]);

    return (
        <SnackbarContent ref={ref}>
            <div className="alert alert-danger alert-dismissible" role="alert">
                <div className="d-flex">
                    <div>
                        <IconAlertTriangle
                            className="pe-2 text-danger"
                            width={34}
                        />
                    </div>
                    <div>
                        <h4 className="alert-title">
                            Oh snap! You got an error
                        </h4>
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

Danger.displayName = "Danger";

export default Danger;
